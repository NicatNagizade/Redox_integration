<?php

namespace Utils\Http;

class Http
{
    /**
     * For sending post request
     *
     * @param  string  $url
     * @param  array  $options
     * @return \Psr\Http\Message\ResponseInterface
     */

    public static function post(string $url, array $options = [])
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', $url, $options);
        return $response;
    }
}
