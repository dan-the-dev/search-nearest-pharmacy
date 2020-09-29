<?php

require __DIR__ . '/vendor/autoload.php';

use Datto\JsonRpc\Http\Examples\AuthenticatedServer;
use infrastructure\RequestHandler;

$requestHandler = new RequestHandler();
$server = new AuthenticatedServer($requestHandler);

$server->reply();