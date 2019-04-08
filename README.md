# Dritux Health Check
A SDK to check the health of your application


### Requirements

- PHP Extension bcmath
- PHP Extension curl
- PHP Extension redis
- PHP Extension pdo
- PHP Extension xml
- PHP Extension mbstring
- PHP Extension bcmath

### Available adapters

* Service Status
    - RebbiMq
    - Mysql
    - Redis
    - Http
* Build Info
    - Bitbucket
* Permission Check
    - File
    - Path
* Proccess Check
    - Ps
* System Check
    - % used memory
    - % used CPU
    - Timezone
    - Date time
    - hostname
    - restart time info



### Key files

* `src/Hc/Healthz.php`: Main Class
* `src/Hc/Build`: Git log information and last commit
* `src/Hc/Permission`: Check permission file and directory
* `src/Hc/Proccess`: Check proccess linux ps
* `src/Hc/Service`: Check queue, cache, databases connections
* `src/Hc/System`: Check system information
* `examples`: An example code
* `tests`: Unit and Integration Tests


### Installation example
Then run the command:
```
$ composer require dritux/php-healthcheck
```


### Basic Usage
```php

<?php

use Dr\Hc\Healthz;

$healthz = new Healthz([
        "service" => [
            "mysql" => [
                "host"=>getenv(),
                "port"=>getenv(),
                "username"=>getenv(),
                "password"=>getenv(),
                "dbname"=>getenv()
            ],
            "rabbitmq" => [
                "host"=>getenv(),
                "port"=>getenv(),
                "username"=>getenv(),
                "password"=>getenv(),
                "vhost"=>getenv(),
            ],
            "redis" => [
                "uri"=>getenv(),
            ],
            "http" => [
                [
                    "name" => getenv(),
                    "port" => getenv(),
                    "method" => getenv(),
                    "uri" => getenv()
                ]
            ]
        ],
        "build" => [
            "git"=>[
                "driver" => "bitbucket",
                "uri"=>getenv(),
                "project_slug" => getenv(),
                "repository_name" => getenv(),
                "apikey"=> getenv()
            ],
            "environment" => getenv()
        ],
        "permission" => [
            "paths" =>[
                [
                    "path" => getenv()
                ],
            ]
        ],
        "proccess" => [
            "names" => [
                getenv()
            ]
        ]
    ]
);


# Check out seperate services
$healthz->service();
$healthz->build();
$healthz->system();
$healthz->permission();
$healthz->proccess();

# Check main status services
$healthz->status();

# Check all services
$healthz->all();

```


### Running tests

```
$ vendor/bin/phpunit
$ vendor/bin/phpunit --coverage-text
$ vendor/bin/phpunit --testdox tests
```


## Version Guidance

| Version | Status  | Packagist               | Namespace    | Docs                | PSR-7 | PHP Version |
|---------|---------|-------------------------|--------------|---------------------|-------|-------------|
| 1.x     | Latest  | `dritux/php-healthcheck` | `Healthz`    | [v1][health-1-docs] | Yes   | >= 7.0      |
