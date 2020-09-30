<?php

namespace Domain;

class PharmacyWithDistance
{
    private Pharmacy $pharmacy;
    private string $distance;

    public function __construct(Pharmacy $pharmacy, float $distance)
    {
        $this->pharmacy = $pharmacy;
        $this->distance = (string)round($distance, 8);
    }

    public function pharmacy(): Pharmacy
    {
        return $this->pharmacy;
    }

    public function distance(): string
    {
        return $this->distance;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->pharmacy->name(),
            'distance' => $this->distance,
            'location' => $this->pharmacy->location()->toArray()
        ];
    }
}