<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Exceptions\MasterNotFoundHttpException;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected $service;
    protected $request;

    public function index() {
        $data = $this->service->index();

        return response()->json($data, 200);
    }

    public function show($id) {
        $data = $this->service->show($id);
        
        return response()->json($data, 200);
    }

    public function store(Request $request) {
        $data = $this->service->store($request);

        return response()->json($data, 201);
    }

    public function update(Request $request, $id) {
        $data = $this->service->update($request, $id);

        return response()->json($data, 200);
    }

    public function destroy($id) {
        $this->service->delete($id);

        return response()->json(['message' => 'Registro deletado com sucesso!'], 200);
    }

    public function toogleActivation ($id) {
        $this->service->toogleActivation($id);

        return response()->noContent();
    }
}
