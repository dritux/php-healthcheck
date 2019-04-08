<?php

namespace Dr\Hc\System\Provider;

use Dr\Hc\System\Provider\AbstractUnixProvider;


class LinuxProvider extends AbstractUnixProvider
{
    /**
     * @var array|null
     */
    protected $cpuInfo;
    /**
     * @var
     */
    protected $cpuInfoByLsCpu;

    /**
     * @inheritdoc
     */
    public function getUptime()
    {
        $time = file_get_contents('/proc/uptime');
        $time = explode('.', $time);
        $time = (int) array_shift($time);

        list($days, $time)    = [(int) ($time / 86400), $time % 86400];
        list($hours, $time)   = [(int) ($time / 3600), $time % 3600];
        list($minutes, $time) = [(int) ($time / 60), $time % 60];
        $seconds = $time;

        return "Days: {$days}, Hours:{$hours}, Minutes:{$minutes}, Seconds:{$seconds}";
    }

    /**
     * @inheritdoc
     */
    public function getTotalMem()
    {
        $meminfo = $this->getMemInfo();
        return array_key_exists('MemTotal', $meminfo) ? intval($meminfo['MemTotal']) : null;
    }

    /**
     * @inheritdoc
     */
    public function getFreeMem()
    {
        $memInfo = $this->getMemInfo();

        $memFree = array_key_exists('MemFree', $memInfo) ? (int) $memInfo['MemFree'] : null;
        $cached  = array_key_exists('Cached', $memInfo) ? (int) $memInfo['Cached'] : null;

        $result = ($memFree ?: null) + ($cached ?: null);

        return $result ? $result: null;
    }

    /**
     * @inheritdoc
     */
    public function getUsedMem()
    {
        return $this->getTotalMem() - $this->getFreeMem();
    }

    /**
     * @inheritdoc
     */
    public function getOsType()
    {
        return 'Linux';
    }

    /**
     * @inheritdoc
     */
    public function getCpuinfo()
    {
        if (!$this->cpuInfo) {
            $cpuInfo = file_get_contents('/proc/cpuinfo');
            $cpuInfo = explode("\n", $cpuInfo);
            $values = [];
            foreach ($cpuInfo as $v) {
                $v = array_map('trim', explode(':', $v));
                if (isset($v[0], $v[1])) {
                    $values[$v[0]] = $v[1];
                }
            }
            $this->cpuInfo = $values;
        }
        return $this->cpuInfo;
    }

    /**
     * @inheritdoc
     */
    public function getCpuModel()
    {
        $cu = $this->getCpuinfo();
        return array_key_exists('model name', $cu) ? $cu['model name'] : null;
    }

    /**
     * @inheritdoc
     */
    public function getCpuCores()
    {
        $cu = $this->getCpuinfo();
        return array_key_exists('siblings', $cu) ? $cu['siblings'] : null;
    }

    /**
     * @inheritdoc
     */
    public function getDiskTotal()
    {
        $du = $this->getDiskUsageInfo();
        return array_key_exists('-', $du) ? $du['-']['size'] : null;
    }

    /**
     * @inheritdoc
     */
    public function getDiskFree()
    {
        $du = $this->getDiskUsageInfo();
        return array_key_exists('-', $du) ? $du['-']['avail'] : null;
    }

    /**
     * @return string
     */
    public function getDiskUsage()
    {

        $du = $this->getDiskUsageInfo();
        $diskuse = array_key_exists('-', $du) ? $du['-']['used'] : null;

        return $diskuse;
    }
}
