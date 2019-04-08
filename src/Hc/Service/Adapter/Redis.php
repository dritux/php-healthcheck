<?php
namespace Dr\Hc\Service\Adapter;

use Dr\Hc\Service\Adapter\ServiceInterface;
use Dr\Hc\Service\Entity\Service;

class Redis extends Service implements ServiceInterface
{

    public function check()
    {
        $status = $this->isConnected() ? "UP" : "DOWN";
        return $status;
    }

    public function isConnected()
    {
        $host = $this->getHost();
        $port = $this->getPort();

        try {
            $redis = new \Redis();
            $redis->connect($host, $port);
            $ping = $redis->ping() ? true : false;
        } catch (\RedisException $e) {
            $ping = false;
        }
        return $ping;
    }
}
