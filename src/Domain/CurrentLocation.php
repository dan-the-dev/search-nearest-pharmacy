<?php

namespace Domain;

class CurrentLocation
{
    private $latitude;
    private $longitude;

    public function __construct(int $latitude, int $longitude)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    public function latitude(): int
    {
        return $this->latitude;
    }

    public function longitude(): int
    {
        return $this->longitude;
    }
}