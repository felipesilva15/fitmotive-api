<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function __construct(Plan $model, Request $request) {
        $this->model = $model;
        $this->request = $request;
    }
}
