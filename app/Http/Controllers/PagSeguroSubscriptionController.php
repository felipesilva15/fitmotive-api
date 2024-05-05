<?php

namespace App\Http\Controllers;

use App\Exceptions\MasterNotFoundHttpException;
use App\Models\Subscription;
use App\Models\User;
use App\Services\PagSeguro\PagSeguroSubscriptionService;

class PagSeguroSubscriptionController extends Controller
{
    protected $service;

    public function __construct()
    {
        $this->service = new PagSeguroSubscriptionService();
    }

    public function sync(int $id) {
        $subscription = Subscription::find($id);

        if (!$subscription) {
            throw new MasterNotFoundHttpException;
        }

        $response = $this->service->create($subscription);

        return response()->json($response, 200);
    }
}
