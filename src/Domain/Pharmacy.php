<?php

namespace Domain;

class Pharmacy
{
    private $name;
    private $location;

    public function __construct(string $name, Location $location)
    {
        $this->name = $name;
        $this->location = $location;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function location(): Location
    {
        return $this->location;
    }

    public static function fromArray(array $rawData): Pharmacy
    {
        return new Pharmacy($rawData['properties']['Descrizione'], new Location($rawData['geometry']['coordinates'][0], $rawData['geometry']['coordinates'][1]));
    }
}