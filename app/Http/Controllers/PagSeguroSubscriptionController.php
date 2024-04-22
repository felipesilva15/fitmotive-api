<?php

namespace App\Http\Controllers;

use App\Exceptions\MasterNotFoundHttpException;
use App\Models\Plan;
use App\Services\PagSeguro\PagSeguroSubscriptionService;
use Illuminate\Http\Request;

class PagSeguroSubscriptionController extends Controller
{
    protected $service;

    public function __construct()
    {
        $this->service = new PagSeguroSubscriptionService();
    }

    public function syncPlan(int $id) {
        $plan = Plan::find($id);

        if (!$plan) {
            throw new MasterNotFoundHttpException;
        }

        $response = $this->service->createPlan($plan);

        return response()->json($response, 200);
    }
}
