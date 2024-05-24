<?php

namespace App\Http\Controllers;

use App\Models\QrCode;
use Illuminate\Http\Request;

class QrCodeController extends Controller
{
    public function __construct(QrCode $model, Request $request) {
        $this->model = $model;
        $this->request = $request;
    }
}
