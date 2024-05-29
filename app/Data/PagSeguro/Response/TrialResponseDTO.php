<?php

namespace App\Data\PagSeguro\Response;

use Spatie\DataTransferObject\DataTransferObject;

class TrialResponseDTO extends DataTransferObject
{
    public string | null $end_at;
    public string | null $start_at;
}