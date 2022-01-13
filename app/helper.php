<?php

use Utils\Request\Request;

/**
 * 
 *
 * @param string $key
 * @param mixed $default
 * @return mixed
 */
function request(string $key = '', $default = null)
{
    $request = Request::instance();
    if ($key === '') {
        return $request;
    }
    return $request->request($key, $default);
}

/**
 *
 * @param string $key
 * @param mixed $default
 * @return mixed
 */
function env(string $key = '', $default = null)
{
    if ($key === '') {
        return $_ENV;
    }
    if (isset($_ENV[$key])) {
        return $_ENV[$key];
    }
    return $default;
}

/**
 *
 * @param string $string
 * @param string $startString
 * @return boolean
 */
function startsWith(string $string, string $startString)
{
    $len = strlen($startString);
    return (substr($string, 0, $len) === $startString);
}
