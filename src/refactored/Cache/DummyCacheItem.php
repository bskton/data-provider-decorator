<?php
/**
 * Created by PhpStorm.
 * User: ilya
 * Date: 01.12.18
 * Time: 21:10
 */

namespace AppName\Cache;

use Psr\Cache\CacheItemInterface;

class DummyCacheItem implements CacheItemInterface
{
    public function getKey()
    {
        return null;
    }

    public function get()
    {
        return null;
    }

    public function isHit()
    {
        return null;
    }

    public function set($value)
    {
        return $this;
    }

    public function expiresAt($expiration)
    {
        return null;
    }

    public function expiresAfter($time)
    {
        return null;
    }
}