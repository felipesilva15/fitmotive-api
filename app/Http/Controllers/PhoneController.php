<?php

namespace App\Http\Controllers;

use App\Models\Phone;
use App\Services\System\PhoneService;
use Illuminate\Http\Request;

class PhoneController extends Controller
{
    public function __construct(Phone $model, Request $request) {
        $this->model = $model;
        $this->request = $request;
    }
}
