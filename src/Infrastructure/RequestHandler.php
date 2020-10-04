<?php

namespace infrastructure;

use Application\SearchNearestPharmacyRequest;
use Datto\JsonRpc\Evaluator as JsonRpcEvaluator;
use Domain\PharmaciesRepository;
use Domain\SearchNearestPharmacy;
use Domain\Location;
use Exception;

class RequestHandler implements JsonRpcEvaluator
{
    private PharmaciesRepository $pharmaciesRepository;
    
    public function __construct(PharmaciesRepository $pharmaciesRepository)
    {
        $this->pharmaciesRepository = $pharmaciesRepository;
    }

    public function evaluate($method, $arguments)
    {
        if ($method === 'SearchNearestPharmacy') {
            try {
                return $this->searchNearestPharmacy($arguments);
            } catch (Exception $e) {
                return $this->error('Something bad happened');
            }
        }

        return $this->error('Unknown method');
    }

    private function searchNearestPharmacy($arguments)
    {
        $latitude = $arguments['currentLocation']['latitude'];
        $longitude = $arguments['currentLocation']['longitude'];
        $range = $arguments['range'];
        $limit = $arguments['limit'];

        if (!is_int($range) || !is_int($limit)) {
            throw new Exception();
        }

        $request = new SearchNearestPharmacyRequest(new Location($latitude, $longitude), $range, $limit);
        $pharmacies = (new SearchNearestPharmacy($this->pharmaciesRepository))->search($request);

        return [
            'pharmacies' => $pharmacies
        ];
    }

    private function error(string $message)
    {
        return [
            'error' => $message
        ];
    }
}