<?php

namespace App\Data\PagSeguro\Response;

use Spatie\DataTransferObject\DataTransferObject;

class SimpleResponseDTO extends DataTransferObject
{
    public string | null $id;
    public string | null $reference_id;
    public string | null $created_at;
    public string | null $updated_at;
    public array | null $links;
}