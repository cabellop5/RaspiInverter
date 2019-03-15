<?php

namespace RaspiInverter;

use InfluxDB\Point;
use RaspiInverter\Data\CurrentValues;

class Console
{
    /**
     * @var CurrentValues $currentValues
     */
    private $currentValues;

    /**
     * @var DatabaseManager
     */
    private $databaseManager;

    private $keysToSave = [
        'ac_output_voltage',
        'ac_output_frecuency',
        'ac_output_power_va',
        'ac_output_active_power',
        'output_load_percent',
        'battery_voltage',
        'battery_charging_current',
        'temperature',
        'pv_input_current_for_battery',
        'pv_input_voltage',
        'battery_discharge_current',
        'pv_active_power',
    ];

    public function __construct(CurrentValues $currentValues, DatabaseManager $databaseManager)
    {
        $this->currentValues = $currentValues;
        $this->databaseManager = $databaseManager;
    }

    public function run()
    {
        $result = $this->currentValues->get();
        $points = [];
        $timestamp = (new \DateTime())->getTimestamp();

        foreach ($result as $key => $value) {

            if (!in_array($key, $this->keysToSave)) {
                continue;
            }

            $points[] = new Point(
                $key,
                floatval($value),
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