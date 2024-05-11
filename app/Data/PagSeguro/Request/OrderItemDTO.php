<?php

namespace App\Data\PagSeguro\Request;

use Spatie\DataTransferObject\DataTransferObject;

class OrderItemDTO extends DataTransferObject
{
    public string $name;
    public int $quantity;
    public int $unit_amount;
}