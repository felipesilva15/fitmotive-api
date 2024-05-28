<?php

namespace App\Http\Controllers;

use App\Enums\LogActionEnum;
use App\Exceptions\MasterNotFoundHttpException;
use App\Models\Subscription;
use App\Services\PagSeguro\PagSeguroSubscriptionService;
use Illuminate\Routing\Controller as BaseController;
use App\Services\System\LogService;

class PagSeguroSubscriptionController extends BaseController
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

    public function showComplete(int $id) {
        $subscription = Subscription::find($id);

        if (!$subscription) {
            throw new MasterNotFoundHttpException;
        }

        $response = $this->service->showComplete($subscription);

        return response()->json($response, 200);
    }

    public function show(int $id) {
        $subscription = Subscription::find($id);

        if (!$subscription) {
            throw new MasterNotFoundHttpException;
        }

        $response = $this->service->show($subscription);

        return response()->json($response, 200);
    }

    public function invoices(int $id) {
        $subscription = Subscription::find($id);

        if (!$subscription) {
            throw new MasterNotFoundHttpException;
        }

        $response = $this->service->invoices($subscription);

        return response()->json($response, 200);
    }
}
