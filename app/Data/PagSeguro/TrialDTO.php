<?php

namespace App\Data\PagSeguro;

use App\Enums\CurrencyEnum;

class TrialDTO 
{
    private int $days;
    private bool $enabled = false;
    private bool $hold_setup_fee = false;

    public function getDays(): int {
        return  (int) $this->days;
    }

    public function setDays(int $days) {
        return  $this->days = (int) $days;
    }

    public function getEnabled(): bool {
        return  (bool) $this->enabled;
    }

    public function setEnabled(bool $enabled) {
        return  $this->enabled = (bool) $enabled;
    }

    public function getHoldSetupFee(): bool {
        return  (bool) $this->hold_setup_fee;
    }

    public function setHoldSetupFee(bool $hold_setup_fee) {
        return  $this->hold_setup_fee = (bool) $hold_setup_fee;
    }

    public function toArray(): array {
        return get_object_vars($this);
    }
}