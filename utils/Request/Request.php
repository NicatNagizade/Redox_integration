<?php

namespace Utils\Request;

class Request
{
    public static $model = null;
    public $gets = [];
    public $posts = [];
    public $requests = [];
    public $files = [];
    public $headers = [];

    private function __construct()
    {
        $this->gets = $_GET;
        $rawData = json_decode(file_get_contents('php://input'), true);
        if(!is_array($rawData)) {
            $rawData = [];
        }
        $this->posts = array_merge($_POST, $rawData);
        $this->files = $_FILES;
        $this->headers = getallheaders();
        $this->requests = array_merge($this->gets, $this->posts, $this->files);
    }

    public static function instance()
    {
        if (static::$model === null) {
            static::$model = new static;
        }
        return static::$model;
    }

    private function getParams(string $type, string $key = '', $default = null)
    {
        $params = $this->$type;
        if($key === '') {
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
        $key = $arguments[0] ?? '';
        $default = $arguments[1] ?? null;
        return $this->getParams($method, $key, $default);
    }

    public function all()
    {
        return $this->getParams('requests');
    }
}
