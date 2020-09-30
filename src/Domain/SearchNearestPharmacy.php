<?php

namespace Domain;

use Application\SearchNearestPharmacyRequest;

class SearchNearestPharmacy
{
    public static function search(SearchNearestPharmacyRequest $request)
    {
        return [
            'pharmacies' => [
                [
                    'name' => 'pharmacyName',
                    'distance' => 123,
                    'location' => [
                        'latitude' => 123,
                        'longitude' => 532
                    ]
                ]
            ]
        ];
    }
}