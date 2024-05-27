<?php

namespace App\Services\System;

use App\Enums\LogActionEnum;
use App\Models\Log;

class LogService
{
    public static function log(string $description, LogActionEnum $action, int $userId = 0): void {
        Log::create([
            'user_id' => $userId ? $userId : auth()->id,
            'description' => $description,
            'action' => $action->value,
            'date' => now()
        ]);
    } 
}