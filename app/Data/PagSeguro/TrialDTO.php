<?php

namespace App\Data\PagSeguro;

use App\Enums\CurrencyEnum;
use Spatie\DataTransferObject\DataTransferObject;

class TrialDTO extends DataTransferObject
{
    public int $days;
    public bool $enabled = false;
    public bool $hold_setup_fee = false;
}