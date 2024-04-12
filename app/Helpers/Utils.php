<?php

namespace App\Helpers;

class Utils
{
    public static function floatToStringBankFormat(float $value): string {
        $formattedValue = (string) ($value * 100);
        
        return $formattedValue;
    }
}
