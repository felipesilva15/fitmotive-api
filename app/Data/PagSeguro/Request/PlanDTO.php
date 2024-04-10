<?php

namespace App\Data\PagSeguro\Request;

use Spatie\DataTransferObject\DataTransferObject;

class PlanDTO extends DataTransferObject
{
    public string $id;
    public string $reference_id;
    public string $name;
    public string $description;
    public AmountDTO $amount;
    public IntervalDTO $interval;
    public TrialDTO $trial;
    public array $payment_method;
}