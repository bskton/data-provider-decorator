<?php

namespace AppName\Integration;

interface DataProvider
{
    /**
     * @param array $request
     *
     * @return array
     */
    public function get(array $request);
}