<?php

namespace App\Data\PagSeguro\Request;

use App\Models\Subscription;
use Spatie\DataTransferObject\DataTransferObject;

class SubscriptionDTO extends DataTransferObject
{
    public string $reference_id;
    public SimpleRequestDTO $plan;
    public SimpleRequestDTO $customer;
    public array | null $payment_method;
    public bool $pro_rata;

    public static function fromModel(Subscription $model) {
        return new self([
            'reference_id' => (string) $model->id,
            'plan' => [
                'id' => $model->plan->bank_gateway_id
            ],
            'customer' => [
                'id' => $model->provider->user->bank_gateway_id
            ],
            'payment_method' => [PaymentMethodDTO::fromModel($model->provider->user->payment_method)],
            'pro_rata' => $model->pro_rata
        ]);
    }
}