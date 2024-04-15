<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Services\System\AddressService;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function __construct(Address $model, Request $request) {
        $this->model = $model;
        $this->request = $request;
    }
}
