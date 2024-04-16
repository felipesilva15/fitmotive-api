<?php

namespace App\Enums;

enum BillingRecurrenceEnum: string 
{
    case Weekly = 'WEEKLY';
    case Fornightly = 'FORTNIGHTLY';
    case Monthly = 'MONTHLY';
    case Quarterly = 'QUARTERLY';
    case SemiAnnual = 'SEMI_ANNUAL';
    case Annual = 'ANNUAL';
}