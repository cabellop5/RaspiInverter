<?php

namespace RaspiInverter;

use Symfony\Component\HttpFoundation\JsonResponse;

class App
{
    /**
     * @var DataCollector
     */
    private $dataCollector;

    public function __construct(DataCollector $dataCollector)
    {
        $this->dataCollector = $dataCollector;
    }

    public function run()
    {
        $result = $this->dataCollector->get();

        return new JsonResponse($result, $result['code']);
    }
}