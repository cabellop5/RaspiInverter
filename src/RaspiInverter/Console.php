<?php

namespace RaspiInverter;

use InfluxDB\Point;

class Console
{
    /**
     * @var DataCollector $dataCollector
     */
    private $dataCollector;

    /**
     * @var DatabaseManager
     */
    private $databaseManager;

    public function __construct(DataCollector $dataCollector, DatabaseManager $databaseManager)
    {
        $this->dataCollector = $dataCollector;
        $this->databaseManager = $databaseManager;
    }

    public function run()
    {
        $result = $this->dataCollector->get();
        $points = [];
        $timestamp = (new \DateTime())->getTimestamp();

        foreach ($result as $key => $value) {
            $points[] = new Point(
                $key,
                $value,
                [],
                [],
                $timestamp
            );
        }

        if (!empty($points)) {
            $this->databaseManager->insert($points);
        }
    }
}