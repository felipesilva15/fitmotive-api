<?php

namespace App\Enums;

enum PlanBillingIntervalEnum: string 
{
    case Dayly = 'DAY';
    case Monthly = 'MONTH';
    case Annualy = 'YEAR';
}