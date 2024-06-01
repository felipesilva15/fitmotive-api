<?php

namespace App\Data\System;

use App\Enums\BillingRecurrenceEnum;
use App\Enums\PaymentMethodTypeEnum;
use App\Helpers\Utils;
use App\Models\Address;
use App\Models\Exercice;
use App\Models\Patient;
use App\Models\PaymentMethod;
use App\Models\Phone;
use App\Models\Workout;
use Illuminate\Validation\Rule;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Casters\ArrayCaster;
use Spatie\DataTransferObject\DataTransferObject;

class WorkoutDTO extends DataTransferObject
{
    public int | null $id;
    public int $provider_id;
    public string $name;
    public string | null $description;
    #[CastWith(ArrayCaster::class, ExerciceDTO::class)]
    public array | null $exercices = [];
    public string $created_at;
    public string | null $updated_at;

    public static function fromModel(Workout $model) {
        return new self([
            'id' => $model->id,
            'provider_id' => $model->provider_id,
            'name' => $model->name,
            'description' => $model->description,
            'exercices' => Utils::modelCollectionToDtoCollection($model->exercices, ExerciceDTO::class),
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ]);
    }

    public static function rules(): array {
        return [
            'provider_id' => Workout::rules()['provider_id'],
            'name' => Workout::rules()['name'],
            'description' => Workout::rules()['description'],
            'exercices' => 'required|array|min:1',
            'exercices.*.id' => 'nullable|int',
            'exercices.*.name' => Exercice::rules()['name'],
            'exercices.*.series' => Exercice::rules()['series'],
            'exercices.*.repetitions' => Exercice::rules()['repetitions'],
            'exercices.*.description' => Exercice::rules()['description']
        ];
    } 
}