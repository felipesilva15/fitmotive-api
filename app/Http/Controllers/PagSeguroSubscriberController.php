<?php

namespace App\Http\Controllers;

use App\Enums\LogActionEnum;
use App\Exceptions\MasterNotFoundHttpException;
use App\Models\User;
use App\Services\PagSeguro\PagSeguroSubscriberService;
use App\Services\PagSeguro\PagSeguroSubscriptionService;
use App\Services\System\LogService;

class PagSeguroSubscriberController extends Controller
{
    protected $service;

    public function __construct()
    {
        $this->service = new PagSeguroSubscriberService();
    }

    public function sync(int $id) {
        $user = User::find($id);

        if (!$user) {
            throw new MasterNotFoundHttpException;
        }

        $response = $this->service->create($user);

        LogService::log('Registro de assinante no PagSeguro (ID '.$user->id.')', LogActionEnum::Other);

        return response()->json($response, 200);
    }

    public function subscription(int $id) {
        $user = User::find($id);

        if (!$user) {
            throw new MasterNotFoundHttpException;
        }

        $subscriptionService = new PagSeguroSubscriptionService();
        $response = $subscriptionService->showComplete($user->provider->subscription);

        return response()->json($response, 200);
    }
}
