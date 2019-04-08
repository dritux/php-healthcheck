<?php
namespace Tests;

use Tests\BaseTestCase;
use Dr\Hc\Build\Info;
use Dr\Hc\Build\Adapter\BitBucket;

class BuildTest extends BaseTestCase
{
    public function __construct()
    {
        $this->setupSomeFixtures();
        $this->returnBuild = [
            "commit" => [
                "hash" => "3b348ad700128b54db1129432832a71a27231879",
                "author" => "adriano.fialho",
                "date" => "1541379427000",
            ],
            "environment" => "production"
        ];
        parent::__construct();
    }

    public function testGetSuccessBuildInfo()
    {
        $mock = $this->createMock('Dr\Hc\Build\Info', ['git']);
        $mock->expects($this->any())
        ->method('git')
        ->will($this->returnValue($this->returnBuild));
        $response = $mock->git($this->check->build);
        $this->assertArrayHasKey('commit', $response);
        $this->assertArrayHasKey('environment', $response);
        $this->assertEquals($response['commit']['hash'], '3b348ad700128b54db1129432832a71a27231879');
        $this->assertEquals($response['commit']['author'], 'adriano.fialho');
        $this->assertEquals($response['commit']['date'], '1541379427000');
    }

    public function testGetSuccessBuildWithBitbucketInfo()
    {
        $checks = $this->check->build;
        $build = new Info;
        $build->git($checks);
        $git = $this->createMock(\Dr\Hc\Build\Adapter\BitBucket::class);
        $git->method('get')->willReturn($this->returnBuild);
        $response = $git->get();
        $this->assertArrayHasKey('commit', $response);
        $this->assertArrayHasKey('environment', $response);
        $this->assertEquals($response['commit']['hash'], '3b348ad700128b54db1129432832a71a27231879');
        $this->assertEquals($response['commit']['author'], 'adriano.fialho');
        $this->assertEquals($response['commit']['date'], '1541379427000');
    }

    public function testGetSuccessBuildWithGithubInfo()
    {
        $checks = $this->check->build;
        $checks->git->driver = 'github';
        $build = new Info;
        $build->git($checks);
        $git = $this->createMock(\Dr\Hc\Build\Adapter\GitHub::class);
        $git->method('get')->willReturn(
            [
                "commit" => [
                    "hash" => "3b348ad700128b54db1129432832a71a27231879",
                    "author" => "adriano.fialho",
                    "date" => "1541379427000",
                ],
                "environment" => "production"
            ]
        );
        $response = $git->get();
        $this->assertArrayHasKey('commit', $response);
        $this->assertArrayHasKey('environment', $response);
        $this->assertEquals($response['commit']['hash'], '3b348ad700128b54db1129432832a71a27231879');
        $this->assertEquals($response['commit']['author'], 'adriano.fialho');
        $this->assertEquals($response['commit']['date'], '1541379427000');
    }

    public function testExceptionWithInvalidUri()
    {
        $git = new BitBucket;
        $git->setUri("http://uri-not-exists");
        $git->setApikey("key");
        $git->setProject("project-fake");
        $git->setRepository("repository-fake");
        $git->setEnvironment("development");
        $response = $git->get();
        $this->assertEquals($response['commit']['http']['code'], '500');
        $this->assertEquals($response['commit']['http']['message'], 'Operation timed out');
    }
}
