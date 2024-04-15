<?php

namespace App\Services\System;

use App\Models\Plan;
use Illuminate\Http\Request;

class PlanService extends Service
{
    public function __construct(Plan $model, Request $request) {
        $this->model = $model;
        $this->request = $request;
    }
}