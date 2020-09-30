<?php

namespace Domain;

use Application\SearchNearestPharmacyRequest;
use Closure;
use infrastructure\InMemoryPharmaciesRepository;
use Treffynnon\Navigator as Navigator;
use Treffynnon\Navigator\Distance\Calculator\Haversine as Haversine;

class SearchNearestPharmacy
{
    public function search(SearchNearestPharmacyRequest $request)
    {
        $pharmacies = (new InMemoryPharmaciesRepository())->getAllPharmacies();
        /**
         * @var array<PharmacyWithDistance> $pharmaciesWithDistance
         */
        $pharmaciesWithDistance = array_map($this->getPharmacyWithDistance($request), $pharmacies);
        $pharmaciesWithDistance = array_values(array_filter($pharmaciesWithDistance, function(PharmacyWithDistance $pharmacyWithDistance) use ($request) {
            return $pharmacyWithDistance->distance() <= $request->range();
        }));
        /**
         * @var PharmacyWithDistance $pharmacyWithDistance
         */
        $pharmacyWithDistance = empty($pharmaciesWithDistance) ? null : $pharmaciesWithDistance[0];

        return [
            'pharmacies' => [
                $pharmacyWithDistance ? $pharmacyWithDistance->toArray() : []
            ]
        ];
    }

    /**
     * @param SearchNearestPharmacyRequest $request
     * @return Closure
     */
    private function getPharmacyWithDistance(SearchNearestPharmacyRequest $request): Closure
    {
        return function (Pharmacy $pharmacy) use ($request) {
            $distanceCalculator = Navigator::distanceFactory($request->currentLocation()->latitude(), $request->currentLocation()->longitude(), $pharmacy->location()->latitude(), $pharmacy->location()->longitude());
            $distance = $distanceCalculator->get(new Haversine());
            return new PharmacyWithDistance($pharmacy, $distance);
        };
    }
}