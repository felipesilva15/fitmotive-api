<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Services\System\PlanService;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function __construct(Plan $model, Request $request) {
        $this->service = new PlanService($model, $request);
        $this->request = $request;
    }
}
