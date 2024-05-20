<?php

namespace App\Http\Controllers;

use App\Enums\LogActionEnum;
use App\Exceptions\MasterNotFoundHttpException;
use App\Models\Subscription;
use App\Models\User;
use App\Services\PagSeguro\PagSeguroSubscriptionService;
use App\Services\System\LogService;

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

        LogService::log('Registro de assinatura no PagSeguro (ID '.$subscription->id.')', LogActionEnum::Other);

        return response()->json($response, 200);
    }
}
