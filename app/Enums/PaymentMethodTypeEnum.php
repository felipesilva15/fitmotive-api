<?php

namespace App\Enums;

enum PaymentStatusEnum: string 
{
    case CreditCard = 'CREDIT_CARD';
    case DebitCard = 'DEBIT_CARD';
    case PIX = 'PIX';
    case Boleto = 'BOLETO';
}