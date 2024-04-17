<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Diet;

class DietController extends Controller
{
    public function __construct(Diet $model, Request $request) {
        $this->model = $model;
        $this->request = $request;
    }
}
