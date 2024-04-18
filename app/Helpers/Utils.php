<?php

namespace App\Helpers;

use App\Contracts\DtoInterface;
use Exception;

class Utils
{
    public static function floatToStringBankFormat(float $value): string {
        $formattedValue = (string) ($value * 100);
        
        return $formattedValue;
    }

    public static function modelArrayToDtoArray(array $modelArray, string $dtoClass): array {
        if (!$dtoClass instanceof DtoInterface) {
            throw new Exception("A classe {$dtoClass} não implementa a interface DtoInterface. Não é possível utilizar o método {DtoInterface::class}");
        }

        $dtoArray = [];

        foreach ($modelArray as $model) {
            $dto = $dtoClass::fromModel($model);

            array_push($dtoArray, $dto);
        }
        
        return $dtoArray; 
    }
}
