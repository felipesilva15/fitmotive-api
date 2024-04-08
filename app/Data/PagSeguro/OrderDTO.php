<?php

namespace App\Data\PagSeguro;

class OrderDTO 
{
    private string $id;
    private string $reference_id;

    public function getId(): string {
        return  (string) $this->id;
    }

    public function setId(string $id) {
        return  $this->id = (string) $id;
    }

    public function getReferenceId(): string {
        return  (string) $this->reference_id;
    }

    public function setReferenceId(string $reference_id) {
        return  $this->reference_id = (string) $reference_id;
    }

    public function toArray(): array {
        return get_object_vars($this);
    }
}