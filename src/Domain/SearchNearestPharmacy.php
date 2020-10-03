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
        $pharmaciesWithDistance = array_map($this->pharmacyWithDistance($request), $pharmacies);
        $pharmaciesWithDistance = array_values(array_filter($pharmaciesWithDistance, function(PharmacyWithDistance $pharmacyWithDistance) use ($request) {
            return $pharmacyWithDistance->distance() <= $request->range();
        }));
        /**
         * @var PharmacyWithDistance $pharmacyWithDistance
         */
        $limitedPharmaciesWithDistance = empty($pharmaciesWithDistance) ? null : array_slice($pharmaciesWithDistance, 0, $request->limit());
        $responsePharmacies = array_map($this->responsePharmacies(), $limitedPharmaciesWithDistance);

        return [
            'pharmacies' => [
                $responsePharmacies
            ]
        ];
    }

    /**
     * @param SearchNearestPharmacyRequest $request
     * @return Closure
     */
    private function pharmacyWithDistance(SearchNearestPharmacyRequest $request): Closure
    {
        return function (Pharmacy $pharmacy) use ($request) {
            $distanceCalculator = Navigator::distanceFactory($request->currentLocation()->latitude(), $request->currentLocation()->longitude(), $pharmacy->location()->latitude(), $pharmacy->location()->longitude());
            $distance = $distanceCalculator->get(new Haversine());
            return new PharmacyWithDistance($pharmacy, $distance);
        };
    }

    /**
     * @return Closure
     */
    private function responsePharmacies(): Closure
    {
        return function (PharmacyWithDistance $pharmacyWithDistance) {
            return $pharmacyWithDistance->toArray();
        };
    }

}