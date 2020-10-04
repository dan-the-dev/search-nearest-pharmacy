<?php

use Application\SearchNearestPharmacyRequest;
use Domain\Location;
use Domain\SearchNearestPharmacy;
use infrastructure\InMemoryPharmaciesRepository;
use PHPUnit\Framework\TestCase;

/** @covers \Domain\SearchNearestPharmacy */
class SearchNearestPharmacyTest extends TestCase
{
    public function testItReturnsOnlyPharmaciesInDistanceRange(): void
    {
        $searchNearestPharmacy = new SearchNearestPharmacy(new InMemoryPharmaciesRepository(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'pharmacies_test.json'));
        $request = new SearchNearestPharmacyRequest(new Location('41.10938993', '15.032101'), 3850000, 3);

        $actual = $searchNearestPharmacy->search($request);

        $expected = [
            [
                'name' => 'IORIO EMILIO',
                'distance' => 3846166.6245093,
                'location' => [
                    'latitude' => '15.01483472',
                    'longitude' => '41.24274462',
                ]
            ],
            [
                'name' => 'FLOVILLA MARIO',
                'distance' => 3841534.8052946,
                'location' => [
                    'latitude' => '15.03335296',
                    'longitude' => '41.19565934',
                ]
            ],
            [
                'name' => 'Belmonte Di Dott.sse Belmonte S. Ed E. Snc',
                'distance' => 3836192.6427812,
                'location' => [
                    'latitude' => '15.0324625',
                    'longitude' => '41.10938993',
                ]
            ]
        ];

        $this->assertEquals($expected, $actual);
    }
}