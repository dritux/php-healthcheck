<?php
namespace Dr\Hc\Service\Adapter;

use Dr\Hc\Service\Adapter\ServiceInterface;
use Dr\Hc\Service\Entity\Service;
use GuzzleHttp\Exception\ConnectException;

class Http extends Service implements ServiceInterface
{
    public function check()
    {
        $client = new \GuzzleHttp\Client();

        $url = $this->getUri();
        $name = $this->getName();
        $port = $this->getPort();
        $method = $this->getMethod();

        $url = $url . (empty($port) ? "" : ":" . $port);

        try {
            $request = $client->request(
                $method,
                $url,
                [
                'timeout' => 5
                ]
            );

            $status = $request->getStatusCode() == "200"? "UP" : "DOWN";
        } catch (ConnectException $e) {
            $status = "DOWN";
        }

        return [
            "url" => $url,
            "status" => $status
        ];
    }
}
