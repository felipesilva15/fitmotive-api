<?php

namespace App\Enums;

enum PaymentStatusEnum: string 
{
    case Paid = 'PAID';
    case Waiting = 'WAITING';
    case Canceled = 'CANCELED';
    case Declined = 'DECLINED';
    case InAnalysis = 'IN_ANALYSIS';
    case Authorized = 'AUTHORIZED';
    case Trial = 'TRIAL';
    case Active = 'ACTIVE';
    case UnPaid = 'UNPAID';
}