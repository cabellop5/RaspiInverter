<?php

namespace RaspiInverter;

use InfluxDB\Client;
use InfluxDB\Database;
use InfluxDB\Point;

class DatabaseManager
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var array
     */
    private $config;

    /**
     * @var Database
     */
    private $database;

    public function __construct(Client $client, array $config)
    {
        $this->client = $client;
        $this->config = $config;
    }

    /**
     * @param Point[] $points
     * @throws \InfluxDB\Exception
     * @return bool
     */
    public function insert(array $points)
    {
        return $this->getDatabase()->writePoints($points, Database::PRECISION_SECONDS);
    }

    /**
     * @return Database
     */
    private function getDatabase()
    {
        if (null !== $this->database) {
            return $this->database;
        }

        $this->database = $this->client->selectDB($this->config['database_name']);

        return $this->database;
    }
}