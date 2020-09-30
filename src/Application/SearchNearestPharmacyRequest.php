<?php

namespace Application;

use Domain\Location;

class SearchNearestPharmacyRequest
{
    private $currentLocation;
    private $range;
    private $limit;

    public function __construct(Location $currentLocation, int $range, int $limit)
    {
        $this->currentLocation = $currentLocation;
        $this->range = $range;
        $this->limit = $limit;
    }

    public function currentLocation(): Location
    {
        return $this->currentLocation;
    }

    public function range(): int
    {
        return $this->range;
    }

    public function limit(): int
    {
        return $this->limit;
    }
}