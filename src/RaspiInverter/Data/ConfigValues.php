<?php
/**
 * Created by PhpStorm.
 * User: pablo
 * Date: 14/03/19
 * Time: 22:46
 */

namespace RaspiInverter\Data;


class ConfigValues extends AbstractDataCollector
{
    const SIZE = 104;
    const COMMAND = "QPIRI\xF8\x54\r";
    const COUNT = 25;

    /**
     * @return string
     */
    protected function getCommand()
    {
        return self::COMMAND;
    }

    /**
     * @return int
     */
    protected function getSize()
    {
        return self::SIZE;
    }

    /**
     * @return int
     */
    protected function getCountData()
    {
        return self::COUNT;
    }

    /**
     * @return array
     */
    protected function getCalculatedData()
    {
        $result['grid_rating_voltage'] = (float)$this->result[0];
        $result['grid_rating_current'] = (float)$this->result[1];
        $result['ac_output_rating_voltage'] = (float)$this->result[2];
        $result['ac_output_rating_frecuency'] = (float)$this->result[3];
        $result['ac_output_rating_current'] = (float)$this->result[4];
        $result['ac_output_rating_apparent_power'] = (int)$this->result[5];
        $result['ac_output_rating_active_power'] = (int)$this->result[6];
        $result['battery_rating_voltage'] = (float)$this->result[7];
        $result['battery_recharge_voltage'] = (float)$this->result[8];
        $result['battery_under_voltage'] = (float)$this->result[9];
        $result['battery_bulk_voltage'] = (float)$this->result[10];
        $result['battery_float_voltage'] = (float)$this->result[11];
        $result['battery_type'] = (int)$this->result[12];
        $result['current_max_ac_charging'] = (int)$this->result[13];
        $result['current_max_charging_current'] = (int)$this->result[14];
        $result['input_voltage_range'] = (int)$this->result[15];
        $result['output_source_priority'] = (int)$this->result[16];
        $result['charger_source_priority'] = (int)$this->result[17];
        $result['parallel_max_num'] = (int)$this->result[18];
        $result['machine_type'] = (int)$this->result[19];
        $result['topology'] = (int)$this->result[20];
        $result['output_mode'] = (int)$this->result[21];
        $result['battery_re_discharge_voltage'] = (int)$this->result[22];
        $result['pv_condition'] = (int)$this->result[23];
        $result['pv_power_balance'] = (int)$this->result[24];

        return $result;
    }
}