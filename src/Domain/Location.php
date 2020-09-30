<?php

namespace Domain;

class Location
{
    private $latitude;
    private $longitude;

    public function __construct(string $latitude, string $longitude)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    public function latitude(): string
    {
        return $this->latitude;
    }

    public function longitude(): string
    {
        return $this->longitude;
    }

    public function toArray(): array
    {
        return [
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
        ];
    }
}