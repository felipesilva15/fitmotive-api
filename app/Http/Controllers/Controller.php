<?php

namespace App\Http\Controllers;

use App\Contracts\CrudControllerInterface;
use App\Enums\LogActionEnum;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Exceptions\MasterNotFoundHttpException;
use App\Helpers\Utils;
use App\Services\System\LogService;
use Illuminate\Http\Request;

class Controller extends BaseController implements CrudControllerInterface
{
    use AuthorizesRequests, ValidatesRequests;

    protected $model;
    protected $request;
    protected $dto;

    public function index() {
        $query = $this->model::query();
        $filters = $this->request->all();

        // Filtros extras além do fillable
        $othersFillableFields = [];

        // Filtra todos os campos que estão na propriedade fillable da model
        foreach ($filters as $field => $value) {
            if (in_array($field, $this->model->getFillable()) || in_array($field, $othersFillableFields)) {
                if (method_exists($this->model, 'rules')){
                    if ($this->model::rules()[$field] && str_contains($this->model::rules()[$field], 'string')) {
                        $query->where($field, 'like', '%'.trim($value).'%');
                        continue;
                    }
                }

                $query->where($field, $value);
            }
        }

        $query->orderBy('id', 'desc');

        $data = $query->get();

        if($this->dto && method_exists($this->dto, 'fromModel')) {
            $data = Utils::modelCollectionToDtoCollection($data, $this->dto);
        }

        return response()->json($data, 200);
    }

    public function show($id) {
        $data = $this->model::find($id);

        if (!$data) {
            throw new MasterNotFoundHttpException;
        }

        if($this->dto && method_exists($this->dto, 'fromModel')) {
            $data = $this->dto::fromModel($data);
        }
        
        return response()->json($data, 200);
    }

    public function store(Request $request) {
        if (method_exists($this->model, 'rules')){
            $request->validate($this->model::rules());
        }
        
        $data = $this->model::create($request->all());

        if (method_exists($this->model, 'label')) {
            LogService::log('Cadastro de '.$this->model::label().' (ID '.$data->id.')', LogActionEnum::Create);
        }

        return response()->json($data, 201);
    }

    public function update(Request $request, $id) {
        $data = $this->model::find($id);

        if (!$data) {
            throw new MasterNotFoundHttpException;
        }

        if (method_exists($this->model, 'rules')){
            $request->validate($this->model::rules());
        }
            
        $data->update($request->all());

        if (method_exists($this->model, 'label')){
            LogService::log('Atualização de '.$this->model::label().' (ID '.$data->id.')', LogActionEnum::Update);
        }

        return response()->json($data, 200);
    }

    public function destroy($id) {
        $data = $this->model::find($id);

        if (!$data) {
            throw new MasterNotFoundHttpException;
        }

        $data->delete();

        if (method_exists($this->model, 'label')){
            LogService::log('Exclusão de '.$this->model::label().' (ID '.$data->id.')', LogActionEnum::Delete);
        }

        return response()->json(['message' => 'Registro deletado com sucesso!'], 200);
    }

    public function toogleActivation ($id) {
        $data = $this->model::find($id);

        if (!$data) {
            throw new MasterNotFoundHttpException;
        }
        
        $data->update([
            'inactive' => !$data->inactive
        ]);

        return response()->noContent();
    }
}