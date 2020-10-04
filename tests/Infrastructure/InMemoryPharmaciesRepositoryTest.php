<?php

use Domain\Location;
use Domain\Pharmacy;
use infrastructure\InMemoryPharmaciesRepository;
use PHPUnit\Framework\TestCase;

/** @covers \infrastructure\InMemoryPharmaciesRepository */
class InMemoryPharmaciesRepositoryTest extends TestCase
{
    public function testItGetsAllPharmaciesCorrectly(): void
    {
        $repository = new InMemoryPharmaciesRepository(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'pharmacies_test.json');

        $expected = [
            new Pharmacy('FARMACIA PADULA SNC DI PASQUALE PADULA E C.', new Location('15.11105952', '41.16866648')),
            new Pharmacy('Belmonte Di Dott.sse Belmonte S. Ed E. Snc', new Location('15.0324625', '41.10938993')),
            new Pharmacy('FLOVILLA MARIO', new Location('15.03335296', '41.19565934')),
            new Pharmacy('IORIO EMILIO', new Location('15.01483472', '41.24274462')),
        ];
        $actual = $repository->getAllPharmacies();

        $this->assertEquals($expected, $actual);
    }
}