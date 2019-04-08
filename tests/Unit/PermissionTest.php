<?php
namespace Tests;

use Tests\BaseTestCase;
use Dr\Hc\Permission\Adapter\Path;
use Dr\Hc\Permission\Info;
use Dr\Hc\Helper;

class PermissionTest extends BaseTestCase
{
    public function __construct()
    {
        $this->setupSomeFixtures();
        $this->returnBuild["permissions"]["paths"][] = [
            "path" => "/var/log/nginx/access.log",
            "permission_rule" => "0640",
            "permission_server" => "0640",
            "message" => "Permission is valid"
        ];
        $this->returnBuild["permissions"]["status"] = "UP";
        parent::__construct();
    }

    public function testCheckPermissionInfo()
    {
        $mock = $this->createMock('Dr\Hc\Permission\Info', ['path']);
        $mock->expects($this->any())
        ->method('path')
        ->will($this->returnValue($this->returnBuild));
        $response = $mock->path($this->check->permission);
        foreach ($this->check->permission->paths as $k => $path) {
            if ($k == 0) {
                $this->assertEquals($path->permission, $response['permissions']['paths'][0]['permission_server']);
            }
        }
        $this->assertArrayHasKey('permissions', $response);
    }

    public function testCheckPermissionPathOk()
    {
        $checks = $this->check->permission;
        $permission = new Info;
        $permission->path($this->check->permission);
        $mock = $this->createMock(\Dr\Hc\Permission\Adapter\Path::class);
        $mock->method('permission')->willReturn($this->returnBuild);
        $response = $mock->permission();
        $this->assertArrayHasKey('permissions', $response);
        $this->assertArrayHasKey('paths', $response['permissions']);
        $this->assertArrayHasKey('status', $response['permissions']);
        $this->assertCount(1, $response['permissions']['paths']);
    }

    public function testCheckFileOrPathNotExists()
    {
        $checks = Helper::toObject(
            ["paths" => [
                ["path" => "/var/log/nginx/filenotexists.log", "permission"=>"0777"]
            ]
        ]
        );
        $path = new Path;
        $path->setPaths($checks->paths);
        $response = $path->permission();
        $this->assertEquals($response['status'], 'DOWN');
    }
}
