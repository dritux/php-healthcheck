<?php

namespace Dr\Hc\Service;

use Dr\Hc\Service\Adapter\RabbitMq;
use Dr\Hc\Service\Adapter\Mysql;
use Dr\Hc\Service\Adapter\Http;
use Dr\Hc\Service\Adapter\Redis;

class Info
{
    private $status = 'UP';

    public function check($checks)
    {
        if (isset($checks->rabbitmq)) {
            $rabbitmq = new RabbitMq;
            $rabbitmq->setHost($checks->rabbitmq->host);
            $rabbitmq->setPort($checks->rabbitmq->port);
            $rabbitmq->setUsername($checks->rabbitmq->username);
            $rabbitmq->setPassword($checks->rabbitmq->password);

            if (isset($checks->rabbitmq->vhost)) {
                $rabbitmq->setVhost($checks->rabbitmq->vhost);
            }
            $response['rabbitmq']['status'] = $rabbitmq->check();
            $this->setStatus($response['rabbitmq']);
        }

        if (isset($checks->mysql)) {
            $mysql = new Mysql;
            $mysql->setHost($checks->mysql->host);
            $mysql->setPort($checks->mysql->port);
            $mysql->setUsername($checks->mysql->username);
            $mysql->setPassword($checks->mysql->password);
            $mysql->setDbname($checks->mysql->dbname);

            $response['mysql']['status'] = $mysql->check();
            $this->setStatus($response['mysql']);
        }

        if (isset($checks->redis)) {
            $redis = new Redis;
            $redis->setHost($checks->redis->host);
            $redis->setPort($checks->redis->port);
            $redis->setUsername($checks->redis->username);
            $redis->setPassword($checks->redis->password);

            $response['redis']['status'] = $redis->check();
            $this->setStatus($response['redis']);
        }

        if (isset($checks->http)) {
            $response['http']['status'] = 'UP';
            $http = new Http;
            foreach ($checks->http as $row) {
                $http->setName($row->name);
                $http->setUri($row->uri);
                $http->setMethod($row->method);
                $http->setPort($row->port);

                $http_check = $http->check();

                if ($http_check['status'] ==  'DOWN') {
                    $response['http']['status'] = 'DOWN';
                }

                $response['http'][$row->name] = $http_check;
            }
            $this->setStatus($response['http']);
        }
        $response['status'] = $this->getStatus();

        return $response;
    }

    private function setStatus($status)
    {
        if ($status["status"] == 'DOWN') {
            $this->status = 'DOWN';
        }
        return $this;
    }

    /**
     * @return string
     */
    private function getStatus()
    {
        return $this->status;
    }
}
