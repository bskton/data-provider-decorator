<?php
/**
 * Created by PhpStorm.
 * User: ilya
 * Date: 01.12.18
 * Time: 20:44
 */

namespace AppName\Cache;

use Psr\Cache\CacheItemPoolInterface;
use Psr\Cache\CacheItemInterface;

class DummyCache implements CacheItemPoolInterface
{
    public function getItem($key)
    {
        return new DummyCacheItem();
    }

    public function getItems($keys = [])
    {
        return null;
    }

    public function hasItem($key)
    {
        return null;
    }

    public function clear()
    {
        return null;
    }

    public function deleteItem($key)
    {
        return null;
    }

    public function deleteItems(array $keys)
    {
        return null;
    }

    public function save(CacheItemInterface $item)
    {
        return null;
    }

    public function saveDeferred(CacheItemInterface $item)
    {
        return null;
    }

    public function commit()
    {
        return null;
    }
}