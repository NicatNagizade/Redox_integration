<?php

use Utils\Request\Request;

function request(string $key = '', $default = null) {
    $request = Request::instance();
    if($key === '') {
        return $request;
    }
    return $request->request($key, $default);
}