<?php

namespace Utils\Route;

class Route
{
    public $path = '';
    public $query = '';
    public $method = 'GET';

    public function __construct()
    {
        $url = parse_url($_SERVER['REQUEST_URI']);
        if (isset($url['path'])) {
            $this->path = $url['path'];
        }
        if (isset($url['query'])) {
            $this->query = $url['query'];
        }
        if (in_array($_SERVER['REQUEST_METHOD'], ['GET', 'POST', 'PUT', 'PATCH', 'DELETE'])) {
            $this->method = $_SERVER['REQUEST_METHOD'];
        }
    }

    /**
     * 
     * @param string $path
     * @param string $controller
     * @param string $method
     * @return void
     */
    public function post(string $path, string $controller, string $method)
    {
        if ($this->method === 'POST') {
            $path = startsWith($path, '/') ? $path : '/' . $path;
            if ($path === $this->path) {
                $response = (new $controller)->$method();
                if (is_array($response)) {
                    echo json_encode($response);
                } else {
                    echo $response;
                }
                exit;
            }
        }
    }

    public function notFound()
    {
        http_response_code(404);
        echo '404 Not found';
    }
}
