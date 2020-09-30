<?php

namespace infrastructure;

use Domain\PharmaciesRepository;
use Domain\Pharmacy;

class InMemoryPharmaciesRepository implements PharmaciesRepository
{
    const DATA_PATH = __DIR__ . DIRECTORY_SEPARATOR . "pharmacies.json";

    private array $pharmacies;

    public function __construct()
    {
        $rawPharmacies = (json_decode(file_get_contents(self::DATA_PATH), true))['features'];
        $this->pharmacies = array_map(function ($rawPharmacy) {
            return Pharmacy::fromArray($rawPharmacy);
        }, $rawPharmacies);
    }

    /**
     * @return array<Pharmacy>
     */
    public function getAllPharmacies(): array
    {
        return $this->pharmacies;
    }
}