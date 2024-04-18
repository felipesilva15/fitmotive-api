<?php

namespace App\Helpers;

use App\Contracts\DtoInterface;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;

class Utils
{
    public static function floatToStringBankFormat(float $value): string {
        $formattedValue = (string) ($value * 100);
        
        return $formattedValue;
    }

    public static function modelCollectionToDtoCollection(Collection $modelCollection, string $dtoClass): SupportCollection {
        $convertionMethodName = 'fromModel';

        if (!method_exists($dtoClass, $convertionMethodName)) {
            throw new Exception("A classe {$dtoClass} não possui o método {$convertionMethodName}. Não é possível este método.");
        }

        $dtoCollection = collect($modelCollection)->map(function ($model) use ($dtoClass, $convertionMethodName)  {
            return $dtoClass::{$convertionMethodName}($model);
        });
        
        return $dtoCollection; 
    }
}
