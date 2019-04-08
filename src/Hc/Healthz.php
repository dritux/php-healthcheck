<?php
namespace Dr\Hc;

use Dr\Hc\Build\Info as BuildInfo;
use Dr\Hc\Permission\Info as PermissionInfo;
use Dr\Hc\Proccess\Info as ProccessInfo;
use Dr\Hc\Service\Info as ServiceInfo;
use Dr\Hc\System\Info as SystemInfo;

use Dr\Hc\Helper;

class Healthz
{
    private $checks;
    private $status = '';

    public function __construct(array $data)
    {
        $this->checks = Helper::toObject($data);
    }

    public function build()
    {
        $build = new BuildInfo;
        $response["build"] = $build->git($this->checks->build);
        return $response;
    }

    public function proccess()
    {
        $proccess = new ProccessInfo;
        $response["proccess"] = $proccess->check($this->checks->proccess);
        return $response;
    }

    public function permission()
    {
        $permission = new PermissionInfo;
        $response["permission"] = $permission->path($this->checks->permission);
        return $response;
    }

    public function service()
    {
        $service = new ServiceInfo;
        $response["service"] = $service->check($this->checks->service);
        return $response;
    }

    public function system()
    {
        $system = new SystemInfo;
        $response["system"] = $system->get();
        return $response;
    }

    public function all()
    {
        $response = array_merge(
            $this->service(),
            $this->build(),
            $this->proccess(),
            $this->permission(),
            $this->system()
        );

        $response['status'] = $this->searchDown($response);
        return $response;
    }

    public function status()
    {
        $response = $this->all();
        return [
            "status" => $response['status']
        ];
    }

    private function searchDown($array)
    {
        $status = "UP";
        if (in_array("DOWN", [
            $array['service']['status'],
            $array['proccess']['status'],
            $array['permission']['status'],
        ])) {
            $status = "DOWN";
        }
        return $status;
    }
}
