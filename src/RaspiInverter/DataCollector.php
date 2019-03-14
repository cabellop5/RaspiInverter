<?php

namespace RaspiInverter;

class DataCollector
{
    const SIZE = 110;
    const COMMAND = "QPIGS\xb7\xa9\r";
    const MODE = 'r+';

    /**
     * @var string
     */
    private $device;

    /**
     * @var int
     */
    private $numberRetries;

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
        $data = $this->getData();

        $result = $this->transformData($data);

        if (!$this->isValidResult()) {
            $result = $this->retry();
        }

        return $result;
    }

    /**
     * @return string
     */
    private function getData()
    {
        $hasData = false;
        $data = '';

        $handle = fopen( $this->device, self::MODE );
        fwrite($handle, self::COMMAND);

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

    private function transformData($data)
    {

    }
}