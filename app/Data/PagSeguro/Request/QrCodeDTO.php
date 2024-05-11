<?php

namespace App\Data\PagSeguro\Request;

use App\Data\System\AddressDTO;
use Spatie\DataTransferObject\DataTransferObject;

class QrCodeDTO extends DataTransferObject
{
    public AmountDTO $amount;
    public string $expiration_date;
}