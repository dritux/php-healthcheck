<?php

namespace Dr\Hc\Permission\Entity;

class Permission
{

    private $data;

    /**
     * Set a paths.
     */
    public function setPaths($data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @return array
     */
    public function getPaths()
    {
        return $this->data;
    }
}
