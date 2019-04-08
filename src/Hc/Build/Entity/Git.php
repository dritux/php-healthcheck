<?php

namespace Dr\Hc\Build\Entity;

class Git
{

    private $url;
    private $apikey;
    private $project;
    private $repository;
    private $environment;

    /**
     * Set a url.
     */
    public function setUri($url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return string
     */
    public function getUri()
    {
        return $this->url;
    }

    /**
     * Set a url.
     */
    public function setApikey($apikey)
    {
        $this->apikey = $apikey;
        return $this;
    }

    /**
     * @return string
     */
    public function getApikey()
    {
        return $this->apikey;
    }

    /**
     * Set a project.
     */
    public function setProject($project)
    {
        $this->project = $project;
        return $this;
    }

    /**
     * @return string
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * Set a repository.
     */
    public function setRepository($repository)
    {
        $this->repository = $repository;
        return $this;
    }

    /**
     * @return string
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * Set a environment.
     */
    public function setEnvironment($environment)
    {
        $this->environment = $environment;
        return $this;
    }

    /**
     * @return string
     */
    public function getEnvironment()
    {
        return $this->environment;
    }
}
