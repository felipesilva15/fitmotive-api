<?php

namespace App\Data\PagSeguro\Request;

use App\Models\Charge;
use App\Models\User;
use Spatie\DataTransferObject\DataTransferObject;

class BoletoDTO extends DataTransferObject
{
    public string $due_date;
    public object $instruction_lines;
    public BoletoHolderDTO $holder;
    public AddressDTO $address;

    public static function fromModel(Charge $model) {
        return new self([
            'due_date' => $model->due_date,
            'instruction_lines' => [
                'line_1' => '',
                'line_2' => ''
            ],
            'holder' => BoletoHolderDTO::fromModel($model->patient->user)
        ]);
    }
}