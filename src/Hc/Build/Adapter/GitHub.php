<?php
namespace Dr\Hc\Build\Adapter;

use Dr\Hc\Build\Adapter\GitInterface;
use Dr\Hc\Build\Entity\Git;

class GitHub extends Git implements GitInterface
{

    public function get()
    {
        return [];
    }
}
