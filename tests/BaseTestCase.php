<?php
namespace Tests;

use PHPUnit\Framework\TestCase;
use Dr\Hc\Helper;

abstract class BaseTestCase extends TestCase
{
    /**
     * The data params.
     *
     * @var array
     */
    protected $data;

    /**
     * @coversNothing
     */
    public function setupSomeFixtures()
    {
        $this->data = [
            "service" => [
                "mysql" => [
                    "host"=>"mysql",
                    "port"=>"3306",
                    "username"=>"root",
                    "password"=>"root",
                    "dbname"=>"teste"
                ],
                "rabbitmq" => [
                    "host"=>"rabbit",
                    "port"=>"5672",
                    "username"=>"root",
                    "password"=>"root",
                    "vhost"=>"/",
                ],
                "redis" => [
                    "host"=>"localhost",
                    "port"=>"6379",
                    "username"=>"root",
                    "password"=>"root"
                ],
                "http" => [
                    [
                        "name" => "application_name",
                        "port" => "80",
                        "method" => "GET",
                        "uri" => "domain.com.br"
                    ],
                    [
                        "name" => "br",
                        "port" => "80",
                        "method" => "GET",
                        "uri" => "http://br"
                    ]
                ]
            ],
            "build" => [
                "git"=>[
                    "driver" => "bitbucket",
                    "uri"=>"https://bitbucket.org",
                    "project_slug" => "{project_slug}",
                    "repository_name" => "{project_name}",
                    "apikey"=> "{api_key}"
                ],
                "environment" => "production"
            ],
            "permission" => [
                "paths" =>[
                    ["path" => "/var/log/nginx/access.log", "permission"=>"0640"],
                    ["path" => "/var/log/nginx/error.log", "permission"=>"0777"]
                ]
            ],
            "proccess" => [
                "names" => [
                    "proccessFile",
                    "php"
                ]
            ]
        ];
        $this->check = Helper::toObject($this->data);
    }
}
