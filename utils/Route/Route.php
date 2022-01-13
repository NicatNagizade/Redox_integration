<?php

namespace Utils\Route;

class Route
{
    /**
     * 
     * @param string $path
     * @param string $controller
     * @param string $method
     * @return void
     */
    public function post(string $path, string $controller, string $method)
    {
        if (request()->getMethod() === 'POST') {
            $path = startsWith($path, '/') ? $path : '/' . $path;
            if ($path === request()->getPath()) {
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

    /**
     *
     * @return void
     */
    public function notFound()
    {
        http_response_code(404);
        echo '404 Not found';
        exit;
    }
}
