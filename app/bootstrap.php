<?php

use RaspiInverter\App;
use RaspiInverter\Console;
use RaspiInverter\Data\ConfigValues;
use RaspiInverter\Data\CurrentValues;
use RaspiInverter\DatabaseManager;

$container['config'] = function () {
    return require_once __DIR__ . '/config.php';
};

$container['console'] = function ($container) {
    return new Console(
        $container['current_values'],
        $container['database_manager'],
        $container['config_values']
    );
};

$container['app'] = function ($container) {
    return new App(
        $container['current_values'],
        $container['config_values']
    );
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

$container['config_values'] = function ($container) {
    return new ConfigValues(
        $container['config']['device'],
        $container['config']['number_retries']
    );
};

$container['current_values'] = function ($container) {
    return new CurrentValues(
        $container['config']['device'],
        $container['config']['number_retries']
    );
};

