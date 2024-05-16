<?php

namespace App\Data\PagSeguro\Request;

use App\Models\PaymentMethod;
use Spatie\DataTransferObject\DataTransferObject;

class CardDTO extends DataTransferObject
{
    public string $number;
    public string $exp_year;
    public string $exp_month;
    public bool $store;
    public CardHolderDTO $holder;

    public static function fromModel(PaymentMethod $model) {
        return new self([
            'number' => $model->card_number,
            'exp_year' => $model->exp_year,
            'exp_month' => $model->exp_month,
            'store' => false,
            'holder' => CardHolderDTO::fromModel($model->user)
        ]);
    }
}