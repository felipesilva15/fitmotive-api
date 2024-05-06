<?php

namespace App\Http\Controllers;

use App\Models\FinancialTransaction;
use Illuminate\Http\Request;

class FinancialTransactionController extends Controller
{
    public function __construct(FinancialTransaction $model, Request $request) {
        $this->model = $model;
        $this->request = $request;
    }
}
