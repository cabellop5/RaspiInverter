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
        $result['grid_rating_voltage'] = $this->result[0];
        $result['grid_rating_currente'] = $this->result[1];
        $result['ac_output_rating_voltage'] = $this->result[2];
        $result['ac_output_rating_frecuency'] = $this->result[3];
        $result['ac_output_rating_current'] = $this->result[4];
        $result['ac_output_rating_apparent_power'] = $this->result[5];
        $result['ac_output_rating_active_power'] = $this->result[6];
        $result['battery_rating_voltage'] = $this->result[7];
        $result['battery_recharge_voltage'] = $this->result[8];
        $result['battery_under_voltage'] = $this->result[9];
        $result['battery_bulk_voltage'] = $this->result[10];
        $result['battery_float_voltage'] = $this->result[11];
        $result['battery_type'] = $this->result[12];
        $result['current_max_ac_charging'] = $this->result[13];
        $result['current_max_charging_current'] = $this->result[14];
        $result['input_voltage_range'] = $this->result[15];
        $result['output_source_priority'] = $this->result[16];
        $result['charger_source_priority'] = $this->result[17];
        $result['parallel_max_num'] = $this->result[18];
        $result['machine_type'] = $this->result[19];
        $result['topology'] = $this->result[20];
        $result['output_mode'] = $this->result[21];
        $result['battery_re_discharge_voltage'] = $this->result[22];
        $result['pv_condition'] = $this->result[23];
        $result['pv_power_balance'] = $this->result[24];

        return $result;
    }
}