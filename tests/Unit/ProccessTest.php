<?php
namespace Tests;

use Tests\BaseTestCase;
use Dr\Hc\Proccess\Info;
use Dr\Hc\Proccess\Adapter\Ps;

class ProccessTest extends BaseTestCase
{
    public function __construct()
    {
        $this->setupSomeFixtures();
        $this->checks = $this->check->proccess;
        parent::__construct();
    }

    public function testCheckProccessInfoOk()
    {
        $info = new Info;
        $info->check($this->checks);
        $return[] = [
            "status" => "UP",
            "proccess_name" => "proccessFile",
            "proccess_info" => [
                [
                    "uname" => "root",
                    "pid" => "29152",
                    "pcpu" => "100",
                    "pmem" => "0.2",
                    "start_time" => "14:03",
                    "args" => "php tests/Mock/proccessFile.php",
                ]
            ]
        ];
        $mock = $this->createMock(\Dr\Hc\Proccess\Adapter\Ps::class);
        $mock->method('check')->willReturn($return);
        $mock->setNames($this->checks->names);
        $proccess = $mock->check();

        $this->assertEquals(1, count($proccess));
        foreach ($proccess as $ps) {
            $this->assertEquals('UP', $ps['status']);
            $this->assertEquals('proccessFile', $ps['proccess_name']);
            $this->assertEquals(6, count($ps['proccess_info'][0]));
        }
    }

    public function testCheckProccessWithPs()
    {
        $info = new Info;
        $info->check($this->checks);

        $ps = new Ps;
        $ps->setNames($this->checks->names);
        $pscheck = $ps->check();

        $return = [
            "root      4087  0.0  0.2 Mar07 php-fpm: master",
            "www-data  5293 11.5  0.3 19:36 php vendor/bin/phpunit"
        ];
        $mock = $this->createMock(\Dr\Hc\Proccess\Adapter\Ps::class);
        $mock->method('command')->willReturn($return);
        $command = $mock->command("php");

        $this->assertEquals(2, count($command));

        $check = $this->createMock(\Dr\Hc\Proccess\Adapter\Ps::class);
        $check->method('check')->willReturn([
            ["name" => "proccessFile", "status" => "DOWN"],
            ["name" => "proccessNot", "status" => "DOWN"],
            "status" => "DOWN"
        ]);

        $parser = $ps->parser($command, "php");

        foreach ($parser["list"] as $p) {
            $this->assertArrayHasKey('uname', $p);
            $this->assertArrayHasKey('pid', $p);
            $this->assertArrayHasKey('pcpu', $p);
            $this->assertArrayHasKey('pmem', $p);
            $this->assertArrayHasKey('start_time', $p);
            $this->assertArrayHasKey('args', $p);
        }
    }
}
