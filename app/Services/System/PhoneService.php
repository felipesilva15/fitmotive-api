<?php

namespace App\Services\System;

use App\Models\Phone;
use Illuminate\Http\Request;

class PhoneService extends Service
{
    public function __construct(Phone $model, Request $request) {
        $this->model = $model;
        $this->request = $request;
    }
}