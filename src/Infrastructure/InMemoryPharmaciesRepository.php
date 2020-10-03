<?php

namespace infrastructure;

use Domain\PharmaciesRepository;
use Domain\Pharmacy;

class InMemoryPharmaciesRepository implements PharmaciesRepository
{
    const DEFAULT_DATA_PATH = __DIR__ . DIRECTORY_SEPARATOR . 'pharmacies.json';

    private array $pharmacies;

    public function __construct(string $dataPath = null)
    {
        $rawPharmacies = (json_decode(file_get_contents($dataPath ?? self::DEFAULT_DATA_PATH), true))['features'];
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