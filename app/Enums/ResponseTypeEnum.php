<?php

namespace App\Enums;

enum ResponseTypeEnum: string 
{
    case Png = 'PNG';
    case Pdf = 'PDF';
    case Text = 'TEXT';
    case Json = 'JSON';
    case Xml = 'XML';
}