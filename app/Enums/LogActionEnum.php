<?php

namespace App\Enums;

enum LogActionEnum: string 
{
    case Create = 'CREATE';
    case Read = 'READ';
    case Update = 'UPDATE';
    case Delete = 'DELETE';
    case Other = 'OTHER';
}