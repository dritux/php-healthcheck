<?php
namespace Dr\Hc\Build\Adapter;

use Dr\Hc\Build\Adapter\GitInterface;
use Dr\Hc\Build\Entity\Git;
use GuzzleHttp\Exception\RequestException;

class BitBucket extends Git implements GitInterface
{
    private $client;

    public function __construct()
    {
        $this->client = new \GuzzleHttp\Client(['http_errors' => false]);
    }

    public function get()
    {
        $url = $this->getUri();
        $project = $this->getProject();
        $repos = $this->getRepository();

        $return = [
            "commit" => [
                "http" => ["code"=>"404", "message"=>"Not found"],
                "version" => "null",
                "hash" => "null",
                "author" => "null",
                "date" => "null"
            ]
        ];
        $path = "{$url}/rest/api/latest/projects/{$project}/repos/{$repos}/commits";
        try {
            $response = $this->client->get($path, [
                'headers'         => [
                    'Authorization' => 'Bearer '. $this->getApikey()
                ],
                'query' => ['until' => 'master', 'limit' => 1],
                'timeout' => 10
            ]);
            if ($response->getStatusCode() == "200") {
                $body = json_decode($response->getBody()->getContents());

                foreach ($body->values as $key => $value) {
                    $hash = $value->id;
                    $author = $value->author->name;
                    $date = $value->committerTimestamp;
                }
                $return = [
                    "commit" => [
                        "hash" => $hash,
                        "author" => $author,
                        "date" => $date
                    ]
                ];
            }
        } catch (RequestException $e) {
            $return['commit']["http"]['code'] = "500" ;
            $return['commit']["http"]['message'] = "Operation timed out" ;
        }

        return $return;
    }
}
