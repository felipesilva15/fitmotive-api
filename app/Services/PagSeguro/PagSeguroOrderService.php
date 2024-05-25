<?php

namespace App\Services\PagSeguro;

use App\Data\PagSeguro\Request\ChargeDTO;
use App\Data\PagSeguro\Request\OrderDTO;
use App\Data\PagSeguro\Response\OrderResponseDTO;
use App\Data\PagSeguro\Response\SimpleResponseDTO;
use App\Enums\ChargeLinkReferenceEnum;
use App\Enums\HttpMethodEnum;
use App\Enums\LogActionEnum;
use App\Enums\MovementTypeEnum;
use App\Enums\PaymentStatusEnum;
use App\Enums\ResponseTypeEnum;
use App\Exceptions\CustomValidationException;
use App\Models\Charge;
use App\Models\FinancialTransaction;
use App\Models\QrCode;
use App\Services\System\LogService;
use Carbon\Carbon;

class PagSeguroOrderService
{
    private string $baseUrl;
    private PagSeguroApiService $api;

    public function  __construct() {
        $this->baseUrl = env('PAGSEGURO_API_BASE_URL', '').'/orders';
        $this->api = new PagSeguroApiService();
    }

    public function create(Charge $charge) {
        $body = OrderDTO::fromModel($charge)->toArray();
        $response = $this->api->request($this->baseUrl, HttpMethodEnum::POST, $body, OrderResponseDTO::class);

        $charge->update([
            'bank_gateway_id' => $response->id
        ]);

        if (isset($response->charges[0])) {
            foreach ($response->charges[0]->links as $link) {
                if ($link->media == "application/pdf") {
                    continue;
                }

                $charge->charge_links()->create([
                    'uri' => $link->href,
                    'reference' => ChargeLinkReferenceEnum::Boleto,
                    'response_type' => ResponseTypeEnum::Pdf
                ]);

                break;
            }
        }
        
        if (isset($response->qr_codes[0])) {
            $qr_code = $response->qr_codes[0];

            foreach ($qr_code->links as $link) {
                if ($link->media !== "image/png") {
                    continue;
                }

                $charge->charge_links()->create([
                    'uri' => $link->href,
                    'reference' => ChargeLinkReferenceEnum::QrCodePix,
                    'response_type' => ResponseTypeEnum::Png
                ]);

                QrCode::create([
                    'charge_id' => $charge->id,
                    'bank_gateway_id' => $qr_code->id,
                    'image_uri' => $link->href,
                    'text' => $qr_code->text,
                    'amount' => $charge->amount,
                    'expiration_date' => Carbon::create($qr_code->expiration_date)
                ]);

                break;
            }
        }

        LogService::log('Registro de cobrança no PagSeguro (ID '.$charge->id.')', LogActionEnum::Other);

        return $charge;
    }

    public function show(Charge $charge) {
        $body = OrderDTO::fromModel($charge)->toArray();
        $response = $this->api->request($this->baseUrl.'/'.$charge->bank_gateway_id, HttpMethodEnum::GET, $body, '');

        return $response;
    }

    public function pay(Charge $charge) {
        $body = [];
        $response = $this->api->request($this->baseUrl.'/'.$charge->bank_gateway_id.'/pay', HttpMethodEnum::POST, $body, SimpleResponseDTO::class);

        return $response;
    }

    public function checkStatus(Charge $charge) {
        if(!$charge->bank_gateway_id) {
            throw new CustomValidationException('A cobrança não foi registrada! Não é possível sincronizar o status.');
        }

        if ($charge->paid_at) {
            throw new CustomValidationException('A cobrança já foi paga! Não é possível sincronizar o status.');
        }

        if ($charge->payment_status == PaymentStatusEnum::Canceled->value || $charge->payment_status == PaymentStatusEnum::Declined->value) {
            throw new CustomValidationException('A cobrança está cancelada/recusada! Não é possível sincronizar o status.');
        }

        $response = $this->show($charge);

        if (!isset($response['charges'][0]['status'])) {
            throw new CustomValidationException('A cobrança ainda está aguardando pagamento.');
        }

        if ($response['charges'][0]['status'] == $charge->payment_status) {
            throw new CustomValidationException('Não houve nenhuma alteração no status da cobrança.');
        }

        switch ($response['charges'][0]['status']) {
            case PaymentStatusEnum::Paid->value:
                $financialTransaction = FinancialTransaction::create([
                    'description' => 'Recebimento de pagamento',
                    'movement_type' => MovementTypeEnum::Credit,
                    'amount' => $charge->amount,
                    'transaction_date' => Carbon::create($response['charges'][0]['paid_at']),
                    'user_id' => auth()->user()->id
                ]);
        
                $charge->update([
                    'payment_status' => PaymentStatusEnum::Paid,
                    'paid_at' => Carbon::create($response['charges'][0]['paid_at']),
                    'financial_transaction_id' => $financialTransaction->id
                ]);
                break;
            
            default:
                $charge->update([
                    'payment_status' => $response['charges'][0]['status']
                ]);
                break;
        }

        return $charge;
    }
} 