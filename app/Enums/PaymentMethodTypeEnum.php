<?php

namespace App\Enums;

enum PaymentMethodTypeEnum: string 
{
    case CreditCard = 'CREDIT_CARD';
    case PIX = 'PIX';
    case Boleto = 'BOLETO';
}