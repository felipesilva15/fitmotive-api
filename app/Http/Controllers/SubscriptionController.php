<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function __construct(Subscription $model, Request $request) {
        $this->model = $model;
        $this->request = $request;
    }
}
