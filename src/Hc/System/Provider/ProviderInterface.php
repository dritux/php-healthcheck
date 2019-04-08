<?php
namespace Dr\Hc\System\Provider;


interface ProviderInterface
{

    /**
     * @return mixed
     */
    public function getOsType();

    /**
     * @return string
     */
    public function getArchitecture();

    /**
     * Total Memory in bytes
     * @return int|null
     */
    public function getTotalMem();

    /**
     * Free Memory in bytes
     * @return int|null
     */
    public function getFreeMem();

    /**
     * Used Memory in bytes
     * @return int|null
     */
    public function getUsedMem();

    /**
     * @return string
     */
    public function getUser();

    /**
     * @return string
     */
    public function getHostname();

    /**
     * @return int|null
     */
    public function getUptime();

    /**
     * @return int|null
     */
    public function getCpuCores();

    /**
     * @return string|null
     */
    public function getCpuModel();

    /**
     * @return array
     */
    public function getCpuUsage();

    /**
     * @return string
     */
    public function getPhpVersion();

    /**
     * @return array
     */
    public function getPhpModules();

    /**
     * @return mixed
     */
    public function getDiskUsage();

    /**
     * @return mixed
     */
    public function getDiskTotal();

    /**
     * @return mixed
     */
    public function getDiskFree();

    /**
     * @return string
     */
    public function getTime();

    /**
     * @return string
     */
    public function getDate();

    /**
     * @return string
     */
    public function getTimezone();
}
