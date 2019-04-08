<?php
namespace Tests;

use Tests\BaseTestCase;
use Dr\Hc\Service\Info;

class ServiceTest extends BaseTestCase
{
    public function __construct()
    {
        $this->setupSomeFixtures();
        $this->checks = $this->check->service;
        parent::__construct();
    }

    public function testCheckServiceInfoWithStatusUp()
    {
        $info = new Info;
        $info->check($this->checks);
        $mock = $this->createMock(\Dr\Hc\Service\Info::class);
        $mock->method('check')->willReturn([
            "rabbitmq" => ["status" => "UP"],
            "mysql" => ["status" => "UP"],
            "redis" => ["status" => "UP"],
            "http" => ["status" => "UP"]
        ]);
        $service = $mock->check($this->checks);
        $this->assertEquals('UP', $service['rabbitmq']['status']);
        $this->assertEquals('UP', $service['mysql']['status']);
        $this->assertEquals('UP', $service['redis']['status']);
        $this->assertEquals('UP', $service['http']['status']);
    }

    public function testCheckServiceInfoWithStatusDown()
    {
        $info = new Info;
        $info->check($this->checks);
        $mock = $this->createMock(\Dr\Hc\Service\Info::class);
        $mock->method('check')->willReturn([
            "rabbitmq" => ["status" => "DOWN"],
            "mysql" => ["status" => "DOWN"],
            "redis" => ["status" => "DOWN"],
            "http" => ["status" => "DOWN"]
        ]);
        $service = $mock->check($this->checks);
        $this->assertEquals('DOWN', $service['rabbitmq']['status']);
        $this->assertEquals('DOWN', $service['mysql']['status']);
        $this->assertEquals('DOWN', $service['redis']['status']);
        $this->assertEquals('DOWN', $service['http']['status']);
    }
}
