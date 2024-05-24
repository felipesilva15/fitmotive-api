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
use App\Models\Charge;
use App\Models\FinancialTransaction;
use App\Services\System\LogService;

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
                    $charge->charge_links()->create([
                        'uri' => $link->href,
                        'reference' => ChargeLinkReferenceEnum::Boleto,
                        'response_type' => ResponseTypeEnum::Pdf
                    ]);
                }
            }
        }
        
        if (isset($response->qr_codes[0])) {
            foreach ($response->qr_codes[0]->links as $link) {
                if ($link->media == "image/png") {
                    $charge->charge_links()->create([
                        'uri' => $link->href,
                        'reference' => ChargeLinkReferenceEnum::QrCodePix,
                        'response_type' => ResponseTypeEnum::Png
                    ]);
                }
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
        $response = $this->show($charge);
        $response = collect($response);

        if (!isset($response['charges'][0]['status'])) {
            return;
        }

        if ($response['charges'][0]['status'] !== PaymentStatusEnum::Paid->value) {
            return;
        }

        $financialTransaction = FinancialTransaction::create([
            'description' => 'Recebimento de pagamento',
            'movement_type' => MovementTypeEnum::Credit,
            'amount' => $charge->amount,
            'transaction_date' => $response['charges'][0]['paid_at'],
            'user_id' => auth()->user()->id
        ]);

        $charge->update([
            'payment_status' => PaymentStatusEnum::Paid,
            'paid_at' => $response['charges'][0]['paid_at'],
            'financial_transaction_id' => $financialTransaction->id
        ]);

        return $charge;
    }
} 