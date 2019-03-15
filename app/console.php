#!/usr/bin/php
<?php
set_time_limit ( 25);

use Pimple\Container;

require_once __DIR__ . '/../vendor/autoload.php';

$container = new Container();

require_once __DIR__ . '/bootstrap.php';

$container['console']->run();