<?php

namespace AppName\Decorator;

use AppName\Integration\DataProvider;
use DateTime;
use Psr\Cache\CacheItemPoolInterface;

class CacheDecorator extends AbstractDataProvider
{
    private $cache;

    public function __construct(DataProvider $dataProvider, CacheItemPoolInterface $cache)
    {
        $this->cache = $cache;
        parent::__construct($dataProvider);
    }

    /**
     * {@inheritdoc}
     */
    public function get(array $request)
    {
        $cacheKey = $this->getCacheKey($request);
        $cacheItem = $this->cache->getItem($cacheKey);
        if ($cacheItem->isHit()) {
            return $cacheItem->get();
        }
        $response = $this->dataProvider->get($request);
        $cacheItem
            ->set($response)
            ->expiresAt(
                (new DateTime())->modify('+1 day')
            );
        return $response;
    }

    /**
     * @param array $request
     * @return string
     */
    private function getCacheKey(array $request)
    {
        return json_encode($request);
    }
}