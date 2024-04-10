<?php

namespace App\Enums;

enum HttpMethodEnum: string 
{
    case GET = 'get';
    case POST = 'post';
    case PUT = 'put';
    case DELETE = 'delete';
    case PATCH = 'patch';
}