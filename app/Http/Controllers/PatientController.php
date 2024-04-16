<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function __construct(Patient $model, Request $request) {
        $this->model = $model;
        $this->request = $request;
    }
}
