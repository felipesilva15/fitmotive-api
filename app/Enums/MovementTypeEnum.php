<?php

namespace App\Enums;

enum MovementTypeEnum: string 
{
    case Debit = 'DEBIT';
    case Credit = 'CREDIT';
}