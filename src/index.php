<?php

require __DIR__ . '/vendor/autoload.php';

use Datto\JsonRpc\Http\Examples\AuthenticatedServer;
use infrastructure\InMemoryPharmaciesRepository;
use infrastructure\RequestHandler;

$requestHandler = new RequestHandler(new InMemoryPharmaciesRepository());
$server = new AuthenticatedServer($requestHandler);

$server->reply();