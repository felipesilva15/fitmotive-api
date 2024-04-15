<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use App\Services\System\PaymentMethodService;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    public function __construct(PaymentMethod $model, Request $request) {
        $this->service = new PaymentMethodService($model, $request);
        $this->request = $request;
    }
}
