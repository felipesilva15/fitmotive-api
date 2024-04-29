<?php

namespace App\Enums;

enum CrudActionEnum: string 
{
    case Create = 'CREATE';
    case Read = 'READ';
    case Update = 'UPDATE';
    case Delete = 'DELETE';
    case Other = 'OTHER';
}