<?php
namespace Dr\Hc\Service\Adapter;

use Dr\Hc\Service\Adapter\ServiceInterface;
use Dr\Hc\Service\Entity\Service;

class Mysql extends Service implements ServiceInterface
{
    public function check()
    {
        $status = "UP";
        $dbname = $this->getDbname();
        $host = $this->getHost();
        $port = $this->getPort();
        $username = $this->getUsername();
        $password = $this->getPassword();

        $dsn = "mysql:dbname={$dbname};host={$host};port={$port}";
        try {
            $db = new \PDO($dsn, $username, $password);
        } catch (\PDOException $e) {
            $status = "DOWN";
        }
        return $status;
    }
}
