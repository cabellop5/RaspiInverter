<?php

namespace RaspiInverter;

class DataCollector
{
    const SIZE = 110;
    const COMMAND = "QPIGS\xb7\xa9\r";
    const COMMAND2 = "QPIRI\xF8\x54\r";
    const MODE = 'r+';

    /**
     * @var string
     */
    private $device;

    /**
     * @var int
     */
    private $numberRetries;

    private $data;

    public function __construct($device, $numberRetries)
    {
        $this->device = $device;
        $this->numberRetries = $numberRetries;
    }

    /**
     * @return array
     */
    public function get()
    {
        $this->data = $this->getData();

        if ($this->isValidResult()) {
            return $this->transformData();
        }

        if (0 === $this->numberRetries) {
            return $this->getErrorResponse();
        }

        $retry = 0;

        while ($retry < $this->numberRetries) {
            $this->data = $this->getData();

            if ($this->isValidResult()) {
                return $this->transformData();
            }

            $retry++;
        }

        return $this->getErrorResponse();
    }

    /**
     * @return array
     */
    private function getErrorResponse()
    {
        return ['code' => 400, 'message' => 'Data not found'];
    }

    /**
     * @return string
     */
    private function getData()
    {
        $hasData = false;
        $data = '';

        $handle = fopen( $this->device, self::MODE );
        fwrite($handle, self::COMMAND2);

        while (!$hasData) {
            $data .= fread($handle, 8);

            if ('' === $data
                || false !== strpos($data, "\r")
                || strlen($data) >= self::SIZE
            ) {
                $hasData = true;
            }
        }

        fclose($handle);

        return $data;
    }

    /**
     * @return bool
     */
    private function isValidResult()
    {

    }

    /**
     * @return array
     */
    private function transformData()
    {
        $aux = explode(
            ' ',
            str_replace(['('], [''], $this->data));

        $result['grid_rating_voltage'] = $aux[0];
        $result['grid_rating_currente'] = $aux[1];
        $result['ac_output_rating_voltage'] = $aux[2];
        $result['ac_output_rating_frecuency'] = $aux[3];
        $result['ac_output_rating_current'] = $aux[4];
        $result['ac_output_rating_apparent_power'] = $aux[5];
        $result['ac_output_rating_active_power'] = $aux[6];
        $result['battery_rating_voltage'] = $aux[7];
        $result['battery_recharge_voltage'] = $aux[8];
        $result['battery_under_voltage'] = $aux[9];
        $result['battery_bulk_voltage'] = $aux[10];
        $result['battery_float_voltage'] = $aux[11];
        $result['battery_type'] = $aux[12];
        $result['current_max_ac_charging'] = $aux[13];
        $result['current_max_charging_current'] = $aux[14];
        $result['input_voltage_range'] = $aux[15];
        $result['output_source_priority'] = $aux[16];
        $result['charger_source_priority'] = $aux[17];
        $result['parallel_max_num'] = $aux[18];
        $result['machine_type'] = $aux[19];
        $result['topology'] = $aux[20];
        $result['output_mode'] = $aux[21];
        $result['battery_re_discharge_voltage'] = $aux[22];
        $result['pv_condition'] = $aux[23];
        $result['pv_power_balance'] = $aux[24];

        var_dump($result);
        die;
        return $result;
    }
}