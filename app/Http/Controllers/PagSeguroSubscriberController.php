<?php

namespace App\Http\Controllers;

use App\Exceptions\MasterNotFoundHttpException;
use App\Models\Plan;
use App\Models\User;
use App\Services\PagSeguro\PagSeguroSubscriberService;

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

        return response()->json($response, 200);
    }
}
