<?php

namespace App\Enums;

enum ChargeLinkReferenceEnum: string 
{
    case QrCodePix = 'QRCODE_PIX';
    case Boleto = 'BOLETO';
    case Payment = 'PAYMENT';
}