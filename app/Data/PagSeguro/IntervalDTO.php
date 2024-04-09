<?php

namespace App\Data\PagSeguro;

use App\Enums\PlanPeriodEnum;

class IntervalDTO 
{
    private string $unit = PlanPeriodEnum::Monthly;
    private int $value = 1;

    public function getUnit(): string {
        return  (string) $this->unit;
    }

    public function setUnit(string $unit) {
        return  $this->unit = (string) $unit;
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