<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    public function __construct(PaymentMethod $model, Request $request) {
        $this->model = $model;
        $this->request = $request;
    }
}
