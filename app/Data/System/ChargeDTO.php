<?php

namespace App\Data\System;

use App\Enums\PaymentMethodTypeEnum;
use App\Enums\PaymentStatusEnum;
use App\Helpers\Utils;
use App\Models\Charge;
use Carbon\Carbon;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Casters\ArrayCaster;
use Spatie\DataTransferObject\Casters\EnumCaster;
use Spatie\DataTransferObject\DataTransferObject;

class ChargeDTO extends DataTransferObject
{
    public int | null $id;
    public int $provider_id;
    public int $patient_id;
    public int | null $financial_transaction_id;
    public string | null $bank_gateway_id;
    public string $patient_name;
    public string $description;
    #[CastWith(EnumCaster::class, PaymentMethodTypeEnum::class)]
    public PaymentMethodTypeEnum $payment_method;
    public string $due_date;
    public float $amount;
    #[CastWith(EnumCaster::class, PaymentStatusEnum::class)]
    public PaymentStatusEnum $payment_status;
    #[CastWith(ArrayCaster::class, ChargeLinkDTO::class)]
    public array | null $charge_links;
    public QrCodeDTO | null $qr_code;
    public string | null $paid_at;
    public string $created_at;
    public string | null $updated_at;

    public static function fromModel(Charge $model) {
        return new self([
            'id' => $model->id,
            'provider_id' => $model->provider_id,
            'patient_id' => $model->patient_id,
            'financial_transaction_id' => $model->financial_transaction_id,
            'bank_gateway_id' => $model->bank_gateway_id,
            'patient_name' => $model->patient->user->name,
            'description' => $model->description,
            'payment_method' => $model->payment_method,
            'due_date' => Carbon::create($model->due_date)->toISOString(),
            'amount' => $model->amount,
            'payment_status' => $model->payment_status,
            'charge_links' => Utils::modelCollectionToDtoCollection($model->charge_links, ChargeLinkDTO::class),
            'qr_code' => $model->qr_code ? QrCodeDTO::fromModel($model->qr_code) : null,
            'paid_at' => $model->paid_at ? Carbon::create($model->paid_at)->toISOString() : null,
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at,
        ]);
    }
}