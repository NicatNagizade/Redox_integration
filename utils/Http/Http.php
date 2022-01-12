<?php

namespace Utils\Http;

class Http
{
    public function post(string $url)
    {
        // 'https://api.redoxengine.com/endpoint'
        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', $url);
    }
}
