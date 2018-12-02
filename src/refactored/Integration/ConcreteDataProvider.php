<?php

namespace AppName\Integration;

class ConcreteDataProvider implements DataProvider
{
    private $host;
    private $user;
    private $password;

    /**
     * @param $host
     * @param $user
     * @param $password
     */
    public function __construct($host, $user, $password)
    {
        $this->host = $host;
        $this->user = $user;
        $this->password = $password;
    }

    /**
     * {@inheritdoc}
     */
    public function get(array $request)
    {
        if ($request[0] == 'request') {
            return 'response';
        }
        return 'something else';
    }
}
