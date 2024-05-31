<?php

namespace App\Data\PagSeguro\Response;

use Spatie\DataTransferObject\DataTransferObject;

class PlanDTO extends DataTransferObject
{
    public string | null $id;
    public string | null $name;
}