<?php

namespace App\Data\PagSeguro\Request;

use Spatie\DataTransferObject\DataTransferObject;

class SimpleRequestDTO extends DataTransferObject
{
    public string | null $id;
}