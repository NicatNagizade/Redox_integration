<?php

use App\Http\Controllers\RedoxController;
use Utils\Route\Route;

$route = new Route;

$route->post('redox/auth/authenticate', RedoxController::class, 'authenticate');
$route->post('redox/auth/refreshToken', RedoxController::class, 'refreshToken');
$route->post('redox/endpoint', RedoxController::class, 'endpoint');
$route->post('redox/query', RedoxController::class, 'query');

$route->notFound();
