<?php

namespace App\Http\Controllers;

use App\Models\Provider;
use Illuminate\Http\Request;

class ProviderController extends Controller
{
    public function __construct(Provider $model, Request $request) {
        $this->model = $model;
        $this->request = $request;
    }
}
