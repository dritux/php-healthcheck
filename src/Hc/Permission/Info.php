<?php

namespace Dr\Hc\Permission;

use Dr\Hc\Permission\Adapter\Path;

class Info
{
    public function path($checks)
    {
        $path = new Path;
        $path->setPaths($checks->paths);
        return $path->permission();
    }
}
