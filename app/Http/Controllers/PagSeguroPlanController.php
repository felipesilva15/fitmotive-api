<?php

namespace App\Http\Controllers;

use App\Exceptions\MasterNotFoundHttpException;
use App\Models\Plan;
use App\Services\PagSeguro\PagSeguroPlanService;

class PagSeguroPlanController extends Controller
{
    protected $service;

    public function __construct()
    {
        $this->service = new PagSeguroPlanService();
    }

    public function sync(int $id) {
        $plan = Plan::find($id);

        if (!$plan) {
            throw new MasterNotFoundHttpException;
        }

        $response = $this->service->create($plan);

        return response()->json($response, 200);
    }
}
