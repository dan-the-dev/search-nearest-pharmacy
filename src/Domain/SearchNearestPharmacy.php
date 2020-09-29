<?php

namespace Domain;

use Application\SearchNearestPharmacyRequest;

class SearchNearestPharmacy
{
    public static function search(SearchNearestPharmacyRequest $request)
    {
        return $request->range();
    }
}