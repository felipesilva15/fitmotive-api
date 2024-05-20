<?php

namespace App\Http\Controllers;

use App\Data\System\ChargeDTO;
use App\Http\Controllers\Controller;
use App\Models\Charge;
use Illuminate\Http\Request;

class ChargeController extends Controller
{
    public function __construct(Charge $model, Request $request) {
        $this->model = $model;
        $this->request = $request;
        $this->dto = ChargeDTO::class;
    }
}
