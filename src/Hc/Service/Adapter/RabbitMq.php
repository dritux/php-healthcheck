<?php
namespace Dr\Hc\Service\Adapter;

use Dr\Hc\Service\Adapter\ServiceInterface;
use Dr\Hc\Service\Entity\Service;
use PhpAmqpLib\Connection\AMQPConnection;

class RabbitMq extends Service implements ServiceInterface
{
    private $connection;

    public function check()
    {
        $status = "UP";

        if (!$this->connection()) {
            $status = "DOWN";
        }
        return $status;
    }

    /**
     * Returns AMQP connection
     *
     * @return AMQPConnection
     */
    public function connection()
    {
        $host = $this->getHost();
        $port = $this->getPort();
        $username = $this->getUsername();
        $password = $this->getPassword();
        $vhost = $this->getVhost();

        try {
            $this->connection = (new AMQPConnection($host, $port, $username, $password, $vhost))->channel();
        } catch (\Exception $e) {
            $this->connection = false;
        }
        return $this->connection;
    }
}
