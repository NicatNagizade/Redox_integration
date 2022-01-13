<?php

namespace App\Http\Controllers;

use Utils\Http\Http;

class RedoxController
{
    public $url = '';
    public $blobUrl = '';

    /**
     * @return void
     */
    public function __construct()
    {
        $this->url = env('REDOX_APP_URL');
        $this->blobUrl = env('REDOX_BLOB_URL');
    }

    /**
     *
     * @param \Psr\Http\Message\ResponseInterface $response
     * @return StreamInterface
     */
    private function redoxResponse(\Psr\Http\Message\ResponseInterface $response)
    {
        $contentType = $response->getHeaderLine('Content-Type');
        header('Content-Type:' . $contentType);
        http_response_code($response->getStatusCode());
        return $response->getBody();
    }

   /**
    *
    * @return StreamInterface
    */
    public function authenticate()
    {
        $response = Http::post(
            $this->url . '/auth/authenticate',
            [
                'form_params' => [
                    'apiKey' => request()->post('apiKey'),
                    'secret' => request()->post('secret')
                ],
                'http_errors' => false
            ]
        );
        return $this->redoxResponse($response);
    }

    /**
     *
     * @return StreamInterface
     */
    public function refreshToken()
    {
        $response = Http::post(
            $this->url . '/auth/refreshToken',
            [
                'form_params' => [
                    'apiKey' => request()->post('apiKey'),
                    'refreshToken' => request()->post('refreshToken')
                ],
                'http_errors' => false,
            ]
        );
        return $this->redoxResponse($response);
    }

    /**
     *
     * @return StreamInterface
     */
    public function endpoint()
    {
        $response = Http::post(
            $this->url . '/endpoint',
            [
                'json' => request()->post(),
                'headers' => [
                    'Authorization' => request()->header('Authorization'),
                    'Content-Type' => request()->header('Content-Type'),
                ],
                'http_errors' => false,
            ]
        );
        return $this->redoxResponse($response);
    }

    /**
     *
     * @return StreamInterface
     */
    public function query()
    {
        $response = Http::post(
            $this->url . '/query',
            [
                'json' => request()->post(),
                'headers' => [
                    'Authorization' => request()->header('Authorization'),
                    'Content-Type' => request()->header('Content-Type'),
                ],
                'http_errors' => false,
            ]
        );
        return $this->redoxResponse($response);
    }
}
