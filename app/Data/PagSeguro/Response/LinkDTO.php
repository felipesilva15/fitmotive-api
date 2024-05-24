<?php

namespace App\Data\PagSeguro\Response;

use Spatie\DataTransferObject\DataTransferObject;

class LinkDTO extends DataTransferObject
{
    public string $rel;
    public string $href;
    public string $media;
    public string $type;
}