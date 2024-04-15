<?php

namespace App\Services\System;

use App\Models\Address;
use Illuminate\Http\Request;

class AddressService extends Service
{
    public function __construct(Address $model, Request $request) {
        $this->model = $model;
        $this->request = $request;
    }
}