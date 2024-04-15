<?php

namespace App\Services\System;

use App\Models\Provider;
use Illuminate\Http\Request;

class ProviderService extends Service
{
    public function __construct(Provider $model, Request $request) {
        $this->model = $model;
        $this->request = $request;
    }
}