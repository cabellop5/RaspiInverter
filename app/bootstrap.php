<?php

use RaspiInverter\App;
use RaspiInverter\Console;
use RaspiInverter\DatabaseManager;
use RaspiInverter\DataCollector;

$container['config'] = function () {
    return require_once __DIR__ . '/config.php';
};

$container['console'] = function ($container) {
    return new Console($container['data_collector'], $container['database_manager']);
};

$container['app'] = function ($container) {
    return new App($container['data_collector']);
};

$container['database_manager'] = function ($container) {
    return new DatabaseManager(
        $container['influx_client'],
        $container['config']['influx_db']
    );
};

$container['influx_client'] = function ($container) {
    return new \InfluxDB\Client(
        $container['config']['influx_db']['host'],
        $container['config']['influx_db']['port']
    );
};

$container['data_collector'] = function ($container) {
    return new DataCollector(
        $container['config']['device'],
        $container['config']['number_retries']
    );
};

