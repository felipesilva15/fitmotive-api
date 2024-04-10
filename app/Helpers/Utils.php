<?php

namespace App\Helpers;

class Utils
{
    public static function floatToStringBankFormat($value): string {
        $formattedValue = (string) ($value * 100);
        
        return $formattedValue;
    }
}
