<?php

namespace AppName\Decorator;

use AppName\Integration\DataProvider;

abstract class AbstractDataProvider implements DataProvider
{
    protected $dataProvider;

    /**
     * @param \AppName\Integration\DataProvider $dataProvider
     */
    public function __construct(DataProvider $dataProvider)
    {
        $this->dataProvider = $dataProvider;
    }
}
