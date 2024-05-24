<?php

namespace App\Data\PagSeguro\Request;

use App\Models\Charge;
use App\Models\User;
use Spatie\DataTransferObject\DataTransferObject;

class BoletoDTO extends DataTransferObject
{
    public string $due_date;
    public array $instruction_lines;
    public BoletoHolderDTO $holder;

    public static function fromModel(Charge $model) {
        return new self([
            'due_date' => $model->due_date,
            'instruction_lines' => [
                'line_1' => null,
                'line_2' => null
            ],
            'holder' => BoletoHolderDTO::fromModel($model->patient->user)
        ]);
    }
}