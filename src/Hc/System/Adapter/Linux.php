<?php
namespace Dr\Hc\System\Adapter;

use Dr\Hc\System\Adapter\SystemInterface;
use Dr\Hc\System\Provider\LinuxProvider;

class Linux extends LinuxProvider implements SystemInterface
{

    /**
     * {@inheritdoc}
     */
    public function get()
    {
        return [
            "hostName" => $this->getHostname(),
            "user" => $this->getUser(),
            "serverDate" => $this->getDate(),
            "serverTime" => $this->getTime(),
            "timezone" => $this->getTimezone(),
            "runningSince" => $this->getUptime(),
            "architecture" => $this->getArchitecture(),
            "os" => $this->getOsType(),
            "memory" => [
                "total" => $this->getTotalMem(),
                "used" => $this->getUsedMem(),
                "free" => $this->getFreeMem()
            ],
            "disk" => [
                "total" => $this->getDiskTotal(),
                "used" => $this->getDiskUsage(),
                "free" => $this->getDiskFree()
            ],
            "cpu" => [
                "usedAverage" => $this->getLoadAverage(),
                "coreCount" => $this->getCpuCores(),
                "modelInfo" => $this->getCpuModel(),
                "usageCores" =>$this->getCpuUsage()
            ],
            "php" => [
                "version" => $this->getPhpVersion(),
                "extension" => $this->getPhpModules()
            ]
        ];
    }
}
