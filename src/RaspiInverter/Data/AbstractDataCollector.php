<?php

namespace RaspiInverter\Data;

abstract class AbstractDataCollector
{
    const MODE = 'r+';

    /**
     * @var string
     */
    private $device;

    /**
     * @var int
     */
    private $numberRetries;

    /**
     * @var string
     */
    private $data;

    /**
     * @var array
     */
    protected $result;

    public function __construct($device, $numberRetries)
    {
        $this->device = $device;
        $this->numberRetries = $numberRetries;
    }

    /**
     * @return string
     */
    abstract protected function getCommand();

    /**
     * @return int
     */
    abstract protected function getSize();

    /**
     * @return int
     */
    abstract protected function getCountData();

    /**
     * @return array
     */
    abstract protected function getCalculatedData();

    /**
     * @return array
     */
    public function get()
    {
        $this->data = $this->getData();

        if ($this->isValidResult()) {
            return $this->getCalculatedData();
        }

        if (0 === $this->numberRetries) {
            return $this->getErrorResponse();
        }

        $retry = 0;

        while ($retry < $this->numberRetries) {
            $this->data = $this->getData();

            if ($this->isValidResult()) {
                return $this->getCalculatedData();
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
        fwrite($handle, $this->getCommand());

        while (!$hasData) {
            $data .= fread($handle, 8);

            if ('' === $data
                || false !== strpos($data, "\r")
                || strlen($data) >= $this->getSize()
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
        $aux = explode(
            ' ',
            str_replace(['(', '�'], ['', ''], $this->data)
        );

        if (is_array($aux) && count($aux) >= $this->getCountData()) {
            $this->result = $aux;

            return true;
        }

        return false;
    }
}