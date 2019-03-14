<?php

use Pimple\Container;
use Symfony\Component\HttpFoundation\Response;

require_once __DIR__ . '/../vendor/autoload.php';

$container = new Container();

require_once __DIR__ . '/../app/bootstrap.php';

/** @var Response $response */
$response = $container['app']->run();
$response->send();