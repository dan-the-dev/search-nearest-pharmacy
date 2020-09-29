<?php

namespace infrastructure;

use Application\SearchNearestPharmacyRequest;
use Datto\JsonRpc\Evaluator as JsonRpcEvaluator;
use Domain\CurrentLocation;
use Domain\SearchNearestPharmacy;

class RequestHandler implements JsonRpcEvaluator
{
    public function evaluate($method, $arguments)
    {
        if ($method === 'SearchNearestPharmacy') {
            return self::SearchNearestPharmacy($arguments);
        }

        throw new \Exception();
    }

    private static function SearchNearestPharmacy($arguments)
    {
        $latitude = $arguments['currentLocation']['latitude'];
        $longitude = $arguments['currentLocation']['longitude'];
        $range = $arguments['range'];
        $limit = $arguments['limit'];

        if (!is_int($range) || !is_int($limit)) {
            throw new \Exception();
        }

        $request = new SearchNearestPharmacyRequest(new CurrentLocation($latitude, $longitude), $range, $limit);
        return SearchNearestPharmacy::search($request);
    }
}