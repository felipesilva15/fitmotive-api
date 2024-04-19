<?php

namespace App\Http\Controllers;

use App\Models\Provider;
use App\Services\System\ProviderService;
use Illuminate\Http\Request;
use App\Helpers\Utils;
use App\Data\System\PatientDTO;

class ProviderController extends Controller
{
    public function __construct(Provider $model, Request $request) {
        $this->model = $model;
        $this->request = $request;
    }

    public function patients(int $id) {
        $provider = Provider::find($id);

        if (!$provider) {
            throw new MasterNotFoundHttpException;
        }

        $data = Utils::modelCollectionToDtoCollection($provider->patients, PatientDTO::class);

        return response()->json($data, 200);
    }
}
