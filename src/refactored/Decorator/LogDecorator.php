<?php

namespace AppName\Decorator;

use AppName\Integration\DataProvider;
use Exception;
use Psr\Log\LoggerInterface;

class LogDecorator extends AbstractDataProvider
{
    private $logger;

    public function __construct(DataProvider $dataProvider, LoggerInterface $logger)
    {
        $this->logger = $logger;
        parent::__construct($dataProvider);
    }

    /**
     * {@inheritdoc}
     */
    public function get(array $request)
    {
        try {
            return $this->dataProvider->get($request);
        } catch (Exception $e) {
            $this->logger->critical('Error', [$e->getMessage()]);
        }
        return [];
    }
}