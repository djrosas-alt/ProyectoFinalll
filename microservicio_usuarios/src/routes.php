<?php

use Slim\Routing\RouteCollectorProxy;
use App\Controllers\UserController;

$app->group('/usuarios', function (RouteCollectorProxy $group) {

    $group->post('/register', [UserController::class, 'register']);
    $group->post('/login',    [UserController::class, 'login']);
    $group->get('/validar',   [UserController::class, 'validarToken']);
    $group->delete('/logout', [UserController::class, 'logout']);

});