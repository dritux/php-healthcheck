<?php

namespace Dr\Hc\Service\Entity;

class Service
{
    private $uri;
    private $host;
    private $port;
    private $username;
    private $password;
    private $method;
    private $name;
    private $dbname;
    private $vhost = "/";

    /**
     * Set a uri.
     */
    public function setUri($uri)
    {
        $this->uri = $uri;
        return $this;
    }

    /**
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * Set a host.
     */
    public function setHost($host)
    {
        $this->host = $host;
        return $this;
    }

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * Set a port.
     */
    public function setPort($port)
    {
        $this->port = $port;
        return $this;
    }

    /**
     * @return string
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * Set a username.
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set a password.
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set a method.
     */
    public function setMethod($method)
    {
        $this->method = $method;
        return $this;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Set a name.
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set a dbname.
     */
    public function setDbname($dbname)
    {
        $this->dbname = $dbname;
        return $this;
    }

    /**
     * @return string
     */
    public function getDbname()
    {
        return $this->dbname;
    }
    /**
     * Set a vhost.
     */
    public function setVhost($vhost)
    {
        $this->vhost = $vhost;
        return $this;
    }

    /**
     * @return string
     */
    public function getVhost()
    {
        return $this->vhost;
    }

}
