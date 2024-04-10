<?php

namespace App\Enums;

enum GrantTypeEnum: string 
{
    case SMS = 'sms';
    case AuthorizationCode = 'authorization_code';
    case Challenge = 'challenge';
}