<?php

namespace App\Data\System;

use App\Models\Exercice;
use Spatie\DataTransferObject\DataTransferObject;

class ExerciceDTO extends DataTransferObject
{
    public int | null $id;
    public int | null $workout_id;
    public string $name;
    public int $series;
    public int $repetitions;
    public string | null $description;
    public string $created_at;
    public string | null $updated_at;

    public static function fromModel(Exercice $model) {
        return new self([
            'id' => $model->id,
            'workout_id' => $model->workout_id,
            'name' => $model->name,
            'series' => $model->series,
            'repetitions' => $model->repetitions,
            'description' => $model->description,
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ]);
    }

    public static function rules(): array {
        return Exercice::rules();
    }
}