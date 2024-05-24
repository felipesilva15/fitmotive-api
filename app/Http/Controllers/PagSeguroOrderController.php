<?php

namespace App\Http\Controllers;

use App\Data\System\ChargeDTO;
use App\Enums\LogActionEnum;
use App\Exceptions\MasterNotFoundHttpException;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Charge;
use App\Services\PagSeguro\PagSeguroOrderService;
use App\Services\System\LogService;

class PagSeguroOrderController extends BaseController
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

        return response()->json($response, 200);
    }

    public function show(int $id) {
        $charge = Charge::find($id);

        if (!$charge) {
            throw new MasterNotFoundHttpException;
        }

        $response = $this->service->show($charge);

        return response()->json($response, 200);
    }

    public function pay(int $id) {
        $charge = Charge::find($id);

        if (!$charge) {
            throw new MasterNotFoundHttpException;
        }

        $response = $this->service->pay($charge);

        return response()->json($response, 200);
    }

    public function checkStatus(int $id) {
        $charge = Charge::find($id);

        if (!$charge) {
            throw new MasterNotFoundHttpException;
        }

        if ($charge->paid_at) {
            return response()->json([
                'message' => 'A cobrança já foi paga'
            ], 500);
        }

        $response = $this->service->checkStatus($charge);

        if (!$response) {
            return response()->json([
                'message' => 'Aguardando pagamento!'
            ], 500);
        }

        $data = ChargeDTO::fromModel($response);

        return response()->json($data, 200);
    }
}
