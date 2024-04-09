<?php

namespace App\Data\PagSeguro;

use App\Enums\CurrencyEnum;

class AmountDTO 
{
    private string $currency = CurrencyEnum::Real;
    private int $value;

    public function getCurrency(): string {
        return  (string) $this->currency;
    }

    public function setCurrency(string $currency) {
        return  $this->currency = (string) $currency;
    }

    public function getValue(): int {
        return  (int) $this->value;
    }

    public function setValue(int $value) {
        return  $this->value = (int) $value;
    }

    public function toArray(): array {
        return get_object_vars($this);
    }
}