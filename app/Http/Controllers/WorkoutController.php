<?php

namespace App\Http\Controllers;

use App\Data\System\WorkoutDTO;
use App\Enums\CrudActionEnum;
use App\Enums\LogActionEnum;
use App\Exceptions\MasterNotFoundHttpException;
use App\Helpers\Utils;
use App\Models\Exercice;
use App\Models\Workout;
use App\Services\System\LogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WorkoutController extends Controller
{
    public function __construct(Workout $model, Request $request) {
        $this->model = $model;
        $this->request = $request;
        $this->dto = WorkoutDTO::class;
    }

    public function store(Request $request) {
        $data = $request->validate(WorkoutDTO::rules());

        $workout = DB::transaction(function () use ($data) {
            $workout = $this->model::create($data);

            if (isset($data['exercices'])) {
                foreach ($data['exercices'] as $item) {
                    $workout->exercices()->create($item);
                }
            }

            LogService::log('Cadastro de treino (ID '.$workout->id.')', LogActionEnum::Create);

            return $workout;
        });

        $data = $this->model::find($workout->id);
        $data = WorkoutDTO::fromModel($data);

        return response()->json($data, 201);
    }

    public function update(Request $request, $id) {
        $data = $request->validate(WorkoutDTO::rules($request));
        $workout = $this->model::find($id);

        if (!$workout) {
            throw new MasterNotFoundHttpException();
        }

        if (isset($data['exercices'])) {
            $data['exercices'] = Utils::defineCrudActionOnArray($workout->exercices, $data['exercices']);
        }

        DB::transaction(function () use ($workout, $data) {
            $workout->update([
                'name' => $data['name'],
                'description' => $data['description']
            ]);

            if (isset($data['exercices'])) {
                foreach ($data['exercices'] as $item) {
                    switch ($item['action']) {
                        case CrudActionEnum::Create:
                            $workout->exercices()->create($item);
                            break;

                        case CrudActionEnum::Update:
                            Exercice::find($item['id'])->update([
                                'name' => $item['name'],
                                'series' => $item['series'],
                                'repetitions' => $item['repetitions'],
                                'description' => $item['description']
                            ]);
                            break;

                        case CrudActionEnum::Delete:
                            Exercice::find($item['id'])->delete();
                            break;
                    }
                }
            }

            LogService::log('Atualização de treino (ID '.$workout->id.')', LogActionEnum::Update);

            return $workout;
        });

        $data = $this->model::find($workout->id);
        $data = WorkoutDTO::fromModel($data);

        return response()->json($data, 201);
    }
}
