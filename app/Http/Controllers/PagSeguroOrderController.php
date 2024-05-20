<?php

namespace App\Http\Controllers;

use App\Enums\LogActionEnum;
use App\Exceptions\MasterNotFoundHttpException;
use App\Http\Controllers\Controller;
use App\Models\Charge;
use App\Services\PagSeguro\PagSeguroOrderService;
use App\Services\System\LogService;

class PagSeguroOrderController extends Controller
{
    protected $service;

    public function __construct()
    {
        $this->service = new PagSeguroOrderService();
    }

    public function sync(int $id) {
        $charge = Charge::find($id);

        if (!$charge) {
            throw new MasterNotFoundHttpException;
        }

        $response = $this->service->create($charge);

        LogService::log('Registro de cobrança no PagSeguro (ID '.$charge->id.')', LogActionEnum::Other);

        return response()->json($response, 200);
    }
}
