<?php

namespace App\Helpers;

use App\Enums\CrudActionEnum;
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
            throw new Exception("A classe {$dtoClass} não possui o método {$convertionMethodName}. Não é possível utilizar este método.");
        }

        $dtoCollection = collect($modelCollection)->map(function ($model) use ($dtoClass, $convertionMethodName)  {
            return $dtoClass::{$convertionMethodName}($model);
        });
        
        return $dtoCollection; 
    }

    // public static function defineCrudActionOnArray(Collection $modelData, array $requestData): array {
    //     foreach ($requestData as $key => $item) {
    //         $item['action'] = CrudActionEnum::Create;
    //         $requestData[$key] = $item;
    //     }

    //     foreach ($modelData as $item) {
    //         $found_key = array_search($item->id, array_column($requestData, 'id'));

    //         if ($found_key) {
    //             $requestData[$found_key]['action'] = CrudActionEnum::Update;
    //         } else {
    //             $itemDeleted = $item->toArray();
    //             $itemDeleted['action'] = CrudActionEnum::Delete;
    //             array_push($requestData, $itemDeleted);
    //         }
    //     }

    //     return $requestData;
    // }

    public static function defineCrudActionOnArray(Collection $modelData, array $requestData): array {
        foreach ($requestData as $key => $item) {
            $item['action'] = CrudActionEnum::Create;
            $requestData[$key] = $item;
        }

        foreach ($modelData as $item) {
            $found_key = false;
            
            foreach ($requestData as $key => $requestDataItem) {
                if(!isset($requestDataItem['id'])) {
                    break;
                }

                if($item->id == $requestDataItem['id']) {
                    $found_key = $key;
                    break;
                }
            }

            if (gettype($found_key) == 'integer') {
                $requestData[$found_key]['action'] = CrudActionEnum::Update;
            } else {
                $itemDeleted = $item->toArray();
                $itemDeleted['action'] = CrudActionEnum::Delete;
                array_push($requestData, $itemDeleted);
            }
        }

        return $requestData;
    }
}
