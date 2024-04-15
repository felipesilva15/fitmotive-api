<?php

namespace App\Http\Controllers;

use App\Models\Provider;
use App\Services\System\ProviderService;
use Illuminate\Http\Request;

class ProviderController extends Controller
{
    public function __construct(Provider $model, Request $request) {
        $this->service = new ProviderService($model, $request);
        $this->request = $request;
    }
}
