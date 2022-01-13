<?php

namespace Utils\Request;

class Request
{
    protected static $model = null;
    protected $gets = [];
    protected $posts = [];
    protected $requests = [];
    protected $files = [];
    protected $headers = [];
    protected $method = '';
    protected $path = '';

    private function __construct()
    {
        $this->gets = $_GET;
        $rawData = json_decode(file_get_contents('php://input'), true);
        if (!is_array($rawData)) {
            $rawData = [];
        }
        $this->posts = array_merge($_POST, $rawData);
        $this->files = $_FILES;
        $this->headers = getallheaders();
        $this->requests = array_merge($this->gets, $this->posts, $this->files);
        $url = parse_url($_SERVER['REQUEST_URI']);
        if (isset($url['path'])) {
            $this->path = $url['path'];
        }
        if (in_array($_SERVER['REQUEST_METHOD'], ['GET', 'POST', 'PUT', 'PATCH', 'DELETE'])) {
            $this->method = $_SERVER['REQUEST_METHOD'];
        }
    }

    /**
     * @return Request
     */
    public static function instance()
    {
        if (static::$model === null) {
            static::$model = new static;
        }
        return static::$model;
    }

    /**
     *
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     *
     * @param string $type
     * @param string $key
     * @param mixed $default
     * @return array|string
     */
    private function getParams(string $type, string $key = '', $default = null)
    {
        $params = $this->$type;
        if ($key === '') {
            return $params;
        } else if (isset($params[$key])) {
            return $params[$key];
        } else {
            return $default;
        }
    }

    public function __call($name, $arguments)
    {
        $method = $name . 's';
        $key = isset($arguments[0])  ? $arguments[0] : '';
        $default = isset($arguments[1]) ? $arguments[1] : null;
        return $this->getParams($method, $key, $default);
    }

    /**
     *
     * @return array
     */
    public function all()
    {
        return $this->getParams('requests');
    }
}
