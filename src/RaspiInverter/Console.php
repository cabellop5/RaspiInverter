<?php

namespace RaspiInverter;

use InfluxDB\Point;
use RaspiInverter\Data\ConfigValues;
use RaspiInverter\Data\CurrentValues;

class Console
{
    /**
     * @var CurrentValues $currentValues
     */
    private $currentValues;

    /**
     * @var ConfigValues
     */
    private $configValues;

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

    public function __construct(CurrentValues $currentValues, DatabaseManager $databaseManager, ConfigValues $configValues)
    {
        $this->currentValues = $currentValues;
        $this->databaseManager = $databaseManager;
        $this->configValues = $configValues;
    }

    public function run()
    {
        $result = $this->currentValues->get();
        $points = [];
        $timestamp = (new \DateTime())->getTimestamp();

//        foreach ($result as $key => $value) {
//
//            if (!in_array($key, $this->keysToSave)) {
//                continue;
//            }
//
//            $points[] = new Point(
//                $key,
//                floatval($value),
//                [],
//                [],
//                $timestamp
//            );
//        }

        if ($this->isDataForInsert($result)) {
            $points[] = new Point(
                'pip_query_general_status',
                null,
                [],
                $result,
                $timestamp
            );
        }

        $configs = $this->configValues->get();

        if ($this->isDataForInsert($configs)) {
            $points[] = new Point(
                'pip_query_device_rated_information',
                null,
                [],
                $configs,
                $timestamp
            );
        }

        if (!empty($points)) {
            $this->databaseManager->insert($points);
        }
    }

    /**
     * @param $data
     * @return bool
     */
    private function isDataForInsert($data)
    {
        return !(isset($data['code']) && 400 === (int)$data['code']);
    }
}