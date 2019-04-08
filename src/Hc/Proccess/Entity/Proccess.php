<?php

namespace Dr\Hc\Proccess\Entity;

class Proccess
{

    private $names;

    /**
     * Set a paths.
     */
    public function setNames($names)
    {
        $this->names = $names;
        return $this;
    }

    /**
     * @return array
     */
    public function getNames()
    {
        return $this->names;
    }
}
