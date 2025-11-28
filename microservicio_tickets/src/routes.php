<?php

use Slim\Routing\RouteCollectorProxy;
use App\Controllers\TicketController;

$app->group('/tickets', function ($group) {

    $group->post('/crear', [TicketController::class, 'crear']);
    $group->get('/gestor/{id}', [TicketController::class, 'ticketsGestor']);
    $group->get('/todos', [TicketController::class, 'todos']);
    $group->put('/estado', [TicketController::class, 'cambiarEstado']);
    $group->put('/asignar', [TicketController::class, 'asignarAdmin']);
    $group->post('/comentar', [TicketController::class, 'comentar']);
    $group->get('/historial/{id}', [TicketController::class, 'historial']);

});