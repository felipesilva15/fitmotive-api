<?php

namespace App\Services\System;

use App\Exceptions\MasterNotFoundHttpException;
use Illuminate\Http\Request;

class Service
{
    protected $model;
    protected $request;

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

        $data = $query->get();

        return $data;
    }

    public function show($id) {
        $data = $this->model::find($id);

        if (!$data) {
            throw new MasterNotFoundHttpException;
        }
        
        return $data;
    }

    public function store(Request $request) {
        if (method_exists($this->model, 'rules')){
            $request->validate($this->model::rules());
        }
        
        $data = $this->model::create($request->all());

        return $data;
    }

    public function update(Request $request, $id) {
        $data = $this->model::find($id);

        if (!$data) {
            throw new MasterNotFoundHttpException;
        }

        if (method_exists($this->model, 'rules')){
            $request->validate($this->model::rules($data));
        }
            
        $data->update($request->all());

        return $data;
    }

    public function destroy($id): void {
        $data = $this->model::find($id);

        if (!$data) {
            throw new MasterNotFoundHttpException;
        }

        $data->delete();
    }

    public function toogleActivation ($id): void {
        $data = $this->model::find($id);

        if (!$data) {
            throw new MasterNotFoundHttpException();
        }

        $data->update([
            'inactive' => !$data->inactive
        ]);
    }
}