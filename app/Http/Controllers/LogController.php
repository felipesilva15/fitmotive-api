<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Log;

class LogController extends Controller
{
    public function __construct(Log $model, Request $request) {
        $this->model = $model;
        $this->request = $request;
    }
}
