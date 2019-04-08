<?php
namespace Dr\Hc\Permission\Adapter;

use Dr\Hc\Permission\Adapter\PermissionInterface;
use Dr\Hc\Permission\Entity\Permission;

class Path extends Permission implements PermissionInterface
{

    public function permission()
    {
        $status = "UP";
        $paths = $this->getPaths();

        foreach ($paths as $p) {
            $rule = $this->permissionRule($p->path, $p->permission);
            if (!$rule["valid"]) {
                $status = "DOWN";
            }
            $response["paths"][$p->path] = [
                "octal" => [
                    "rule" => $p->permission,
                    "server" => $rule["octal"]
                ],
                "message" => $rule["message"],
                "status" => $rule["status"]
            ];
        }
        $response["status"] = $status;
        return $response;
    }

    private function permissionRule($path, $permission)
    {
        $status = "DOWN";
        $octal = $this->filePerms($path);

        if ($octal) {
            $message = "Permission is valid";
            $valid = true;
            $status = "UP";
        }

        if ($permission != $octal) {
            $message = "Permission not valid";
            $valid = false;
            $status = "DOWN";
        }

        return [
            "octal" => $octal,
            "message" => $message,
            "valid" => $valid,
            "status" => $status
        ];
    }

    private function filePerms($path, $octal = true)
    {
        if (!file_exists($path)) {
            return false;
        }

        $perms = fileperms($path);
        $cut = $octal ? 2 : 3;
        return substr(decoct($perms), $cut);
    }
}
