<?php

namespace App\Http\Controllers;

use App\Models\Exercice;
use Illuminate\Http\Request;

class ExerciceController extends Controller
{
    public function __construct(Exercice $model, Request $request) {
        $this->model = $model;
        $this->request = $request;
    }
}
