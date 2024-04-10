<?php

namespace App\Data\PagSeguro;

use Spatie\DataTransferObject\DataTransferObject;

class OrderDTO extends DataTransferObject
{
    public string $id;
    public string $reference_id;
}