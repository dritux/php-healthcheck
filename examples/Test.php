<?php
namespace Dr\Hc\Examples;

use Dr\Hc\Healthz;

require_once __DIR__ . '/../vendor/autoload.php';

class Test
{
    public function healthz(Healthz $healthz)
    {
        # Check out seperate services
        $services = $healthz->service();
        $build = $healthz->build();
        $system = $healthz->system();
        $permissions = $healthz->permission();
        $proccess = $healthz->proccess();

        # Check main status services
        $status = $healthz->status();

        # Check all services
        $response = $healthz->all();

        return $response;
    }
}

$response = (new Test())->healthz(new Healthz([
    "service" => [
        "mysql" => [
            "host"=>"localhost",
            "port"=>"3306",
            "username"=>"root",
            "password"=>"root",
            "dbname"=>"teste"
        ],
        "rabbitmq" => [
            "host"=>"localhost",
            "port"=>"5672",
            "username"=>"root",
            "password"=>"root",
            "vhost"=>"/",
        ],
        "redis" => [
            "host"=>"localhost",
            "port"=>"6379",
            "username"=>"root",
            "password"=>"root",
        ],
        "http" => [
            [
                "name" => "tim-vendas",
                "port" => "80",
                "method" => "GET",
                "uri" => "domain.com.br"
            ],
            [
                "name" => "products",
                "port" => "80",
                "method" => "GET",
                "uri" => "domain.com.br"
            ]
        ]
    ],
    "build" => [
        "git"=>[
            "driver" => "bitbucket",
            "uri"=>"https://bitbucket.org",
            "project_slug" => "{your_project_slug}",
            "repository_name" => "{your_repository}",
            "apikey"=> "{your_key}"
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
            "proccessNot"
        ]
    ]
]));

print_r($response);
