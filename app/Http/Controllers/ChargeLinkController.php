<?php

namespace App\Http\Controllers;

use App\Models\ChargeLink;
use Illuminate\Http\Request;

class ChargeLinkController extends Controller
{
    public function __construct(ChargeLink $model, Request $request) {
        $this->model = $model;
        $this->request = $request;
    }
}
