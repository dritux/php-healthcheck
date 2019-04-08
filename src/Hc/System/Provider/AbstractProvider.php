<?php
namespace Dr\Hc\System\Provider;


abstract class AbstractProvider implements ProviderInterface
{
    /**
     * @return string
     */
    public function getPhpVersion()
    {
        return phpversion();
    }

    /**
     * @return string
     */
    public function getHostname()
    {
        return gethostname();
    }

    /**
     * @return string
     */
    public function getUser()
    {
        return get_current_user();
    }

    /**
     * @return string
     */
    public function getArchitecture()
    {
        return php_uname('m');
    }

    /**
     * @inheritdoc
     */
    public function getPhpModules()
    {
        return get_loaded_extensions();
    }

    /**
     * @return string
     */
    public function getTime()
    {
        return date("H:i:s", time());
    }

    /**
     * @return string
     */
    public function getDate()
    {
        return date("Y-m-d", time());
    }

    /**
     * @return string
     */
    public function getTimezone()
    {
        $date = new \DateTime();
        $timeZone = $date->getTimezone();
        return $timeZone->getName();
    }
}
