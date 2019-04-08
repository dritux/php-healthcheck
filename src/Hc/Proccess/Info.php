<?php

namespace Dr\Hc\Proccess;

use Dr\Hc\Proccess\Adapter\Ps;

class Info
{
    public function check($checks)
    {
        $status = 'UP';
        $ps = new Ps;
        $ps->setNames($checks->names);
        $proccess = $ps->check();
        foreach ($proccess as $p) {
            if ($p['status'] ==  'DOWN') {
                $status = 'DOWN';
            }
        }
        $proccess['status'] = $status;
        return $proccess;
    }
}
