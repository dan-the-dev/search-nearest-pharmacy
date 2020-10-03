<?php

namespace Domain;

use Closure;
use Treffynnon\Navigator as Navigator;
use Application\SearchNearestPharmacyRequest;
use Treffynnon\Navigator\Distance\Calculator\Haversine as Haversine;

class SearchNearestPharmacy
{
    private PharmaciesRepository $pharmaciesRepository;

    public function __construct(PharmaciesRepository $pharmaciesRepository)
    {
        $this->pharmaciesRepository = $pharmaciesRepository;
    }

    /**
     * Get all pharmacies, then filter and order them by distance, returning only result required in limit.
     *
     * @param SearchNearestPharmacyRequest $request
     * @return array<PharmacyWithDistance>
     */
    public function search(SearchNearestPharmacyRequest $request): array
    {
        $pharmacies = $this->pharmaciesRepository->getAllPharmacies();
        /** @var array<PharmacyWithDistance> $pharmaciesWithDistance */
        $pharmaciesWithDistance = array_map($this->pharmacyWithDistance($request), $pharmacies);
        usort($pharmaciesWithDistance, $this->orderByDistance());
        $pharmaciesWithDistance = array_values(array_filter($pharmaciesWithDistance, $this->pharmaciesInDistance($request)));
        /** @var PharmacyWithDistance $pharmacyWithDistance */
        $limitedPharmaciesWithDistance = array_slice($pharmaciesWithDistance, 0, $request->limit());
        return array_map($this->responsePharmacies(), $limitedPharmaciesWithDistance);
    }

    /**
     * Calculate distance to pharmacy info.
     *
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
     * Callback useful to order pharmacies by distance, the closest first.
     *
     * @return Closure
     */
    private function orderByDistance(): Closure
    {
        return function (PharmacyWithDistance $previous,PharmacyWithDistance $next) {
            return $previous->distance() < $next->distance();
        };
    }

    /**
     * Callback useful to filter pharmacies removing the ones with distance bigger then requested.
     *
     * @param SearchNearestPharmacyRequest $request
     * @return Closure
     */
    private function pharmaciesInDistance(SearchNearestPharmacyRequest $request): Closure
    {
        return function (PharmacyWithDistance $pharmacyWithDistance) use ($request) {
            return $pharmacyWithDistance->distance() <= $request->range();
        };
    }

    /**
     * Turn pharmacies objects to expected response format.
     *
     * @return Closure
     */
    private function responsePharmacies(): Closure
    {
        return function (PharmacyWithDistance $pharmacyWithDistance) {
            return $pharmacyWithDistance->toArray();
        };
    }

}