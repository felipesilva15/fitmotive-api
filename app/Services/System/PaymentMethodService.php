<?php

namespace App\Services\System;

use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodService extends Service
{
    public function __construct(PaymentMethod $model, Request $request) {
        $this->model = $model;
        $this->request = $request;
    }
}