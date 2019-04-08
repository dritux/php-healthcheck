<?php
namespace Dr\Hc\Proccess\Adapter;

use Dr\Hc\Proccess\Adapter\ProccessInterface;
use Dr\Hc\Proccess\Entity\Proccess;

class Ps extends Proccess implements ProccessInterface
{
    public function check()
    {
        $names = $this->getNames();

        foreach ($names as $name) {
            $command = $this->command($name);
            $response[$name] = [
                "status" => "DOWN"
            ];
            if (count($command) > 0) {
                $response[$name] = $this->parser($command, $name);
            }
        }
        return $response;
    }

    public function parser($command, $name)
    {
        foreach ($command as $pid) {
            $list = preg_split("/[\s,]+/", $pid);
            $parser[] = [
                "uname" => isset($list[0])? $list[0] : "",
                "pid" => isset($list[1])? $list[1] : "",
                "pcpu" => isset($list[2])? $list[2] : "",
                "pmem" => isset($list[3])? $list[3] : "",
                "start_time" => isset($list[4])? $list[4] : "",
                "args" => (isset($list[5])? $list[5] : "") . " " . (isset($list[6])? $list[6] : ""),
            ];
        }
        $result['status'] = "UP";
        $result['list'] = $parser;
        return $result;
    }

    public function command($name)
    {
        exec("ps -eLo uname,pid,pcpu,pmem,start_time,args | grep -i $name | grep -v grep", $pids);
        return $pids;
    }
}
