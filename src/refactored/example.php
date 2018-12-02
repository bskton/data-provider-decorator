<?php

require __DIR__ . '/../../vendor/autoload.php';

use AppName\Cache\DummyCache;
use AppName\Log\DummyLog;
use AppName\Decorator\CacheDecorator;
use AppName\Decorator\LogDecorator;
use AppName\Integration\ConcreteDataProvider;

$logger = new DummyLog();
$cache = new DummyCache();
$advancedDataProvider = new LogDecorator(
    new CacheDecorator(
        new ConcreteDataProvider('host', 'user', 'password'),
        $cache
    ),
    $logger
);
$response = $advancedDataProvider->get(['request']);
var_dump($response);