<?php
namespace Dr\Hc\Tests;

use Tests\BaseTestCase;
use Dr\Hc\Healthz;

class HealthCheckTest extends BaseTestCase
{
    public function __construct()
    {
        $this->setupSomeFixtures();
        parent::__construct();
    }

    public function testHealthCheckWithAll()
    {
        $healthz = new Healthz($this->data);
        $all = $healthz->all();

        $this->assertArrayHasKey('service', $all);
        $this->assertArrayHasKey('build', $all);
        $this->assertArrayHasKey('proccess', $all);
        $this->assertArrayHasKey('permission', $all);
        $this->assertArrayHasKey('system', $all);
    }

    public function testHealthCheckWithStatusDown()
    {
        $healthz = new Healthz($this->data);
        $response = $healthz->status();
        $this->assertEquals('DOWN', $response["status"]);
    }
}
