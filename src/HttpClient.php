<?php
declare(strict_types=1);

namespace Qvbilam\Audit;


use GuzzleHttp\Client;

trait HttpClient
{

    protected function get($url, $query = [], $headers = [])
    {
        return $this->request("get", $url, [
            "headers" => $headers,
            "query" => $query,
        ]);
    }

    protected function post($url, $params = [], $headers = [])
    {
        return $this->request("post", $url, [
            "headers" => $headers,
            "form_params" => $params,
        ]);
    }

    protected function postJson($url, $params = [], $headers = [])
    {
        return $this->request("post", $url, [
            "headers" => $headers,
            "json" => $params,
        ]);
    }

    protected function getClient(array $options = []): Client
    {
        return new Client($options);
    }

    protected function request($method, $url, $options = [])
    {
        $client = $this->getClient($this->getClientOptions());
        return $client->$method($url, $options);
    }

}