<?php

namespace App\Enums;

enum PlanPeriodEnum: string 
{
    case Monthly = 'MONTHLY';
    case SemiAnnual = 'SEMI_ANNUAL';
    case Annualy = 'ANNUALLY';
}