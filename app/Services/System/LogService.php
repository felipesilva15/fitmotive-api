<?php

namespace App\Services\System;

use App\Enums\LogActionEnum;
use App\Models\Log;

class LogService
{
    public static function log(string $description, LogActionEnum $action): void {
        Log::create([
            'user_id' => auth()->user()->id,
            'description' => $description,
            'action' => $action->value,
            'date' => now()
        ]);
    } 
}