<?php

namespace App\Data\PagSeguro\Response;

use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Casters\ArrayCaster;
use Spatie\DataTransferObject\DataTransferObject;

class QrCodeResponseDTO extends DataTransferObject
{
    public string | null $id;
    public string | null $expiration_date;
    public string | null $text;
    #[CastWith(ArrayCaster::class, itemType: LinkDTO::class)]
    public array | null $links;
}