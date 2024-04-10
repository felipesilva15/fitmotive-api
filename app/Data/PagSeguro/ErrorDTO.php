<?php

namespace App\Data\PagSeguro;

use Spatie\DataTransferObject\DataTransferObject;

class ErrorDTO extends DataTransferObject
{
    public string | null $error;
    public string | null $description;
    public string | null $parameter_name;
}