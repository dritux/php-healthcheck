<?php

namespace Dr\Hc\System;

use Dr\Hc\System\Adapter\Linux;

class Info
{
    public function get()
    {
        $linux = new Linux;
        return $linux->get();
    }
}
