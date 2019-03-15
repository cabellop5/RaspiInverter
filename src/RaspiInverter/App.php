<?php

namespace RaspiInverter;

use RaspiInverter\Data\ConfigValues;
use RaspiInverter\Data\CurrentValues;
use Symfony\Component\HttpFoundation\JsonResponse;

class App
{
    /**
     * @var CurrentValues
     */
    private $currentValues;

    /**
     * @var ConfigValues
     */
    private $configValues;

    public function __construct(CurrentValues $currentValues, ConfigValues $configValues)
    {
        $this->currentValues = $currentValues;
        $this->configValues = $configValues;
    }

    public function run()
    {
        $result['current'] = $this->currentValues->get();
        $result['config'] = $this->configValues->get();

        if (isset($result['current']['code']) || isset($result['config']['code'])) {
            $key = isset($result['current']['code']) ? 'current' : 'config';

            return new JsonResponse($result[$key], $result[$key]['code']);
        }

        return new JsonResponse($result);
    }
}