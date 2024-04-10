<?php

namespace App\Enums;

enum PlanPeriodEnum: string 
{
    case Dayly = 'DAY';
    case Monthly = 'MONTH';
    case Annualy = 'YEAR';
}