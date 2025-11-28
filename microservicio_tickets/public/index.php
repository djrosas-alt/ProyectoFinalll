<?php

use Slim\Factory\AppFactory;
use DI\ContainerBuilder;
use Illuminate\Database\Capsule\Manager as Capsule;
use Dotenv\Dotenv;

require __DIR__ . '/../vendor/autoload.php';


$containerBuilder = new ContainerBuilder();
$container = $containerBuilder->build();

AppFactory::setContainer($container);

$app = AppFactory::create();

$app->add(function ($req, $handler) {
    $res = $handler->handle($req);
    return $res
        ->withHeader("Access-Control-Allow-Origin", "*")
        ->withHeader("Access-Control-Allow-Headers", "Content-Type, Authorization")
        ->withHeader("Access-Control-Allow-Methods", "GET, POST, PUT, DELETE, OPTIONS");
});
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$capsule = new Capsule;

$capsule->addConnection([
    "driver" => "mysql",
    "host" => $_ENV["DB_HOST"],
    "database" => $_ENV["DB_NAME"],
    "username" => $_ENV["DB_USER"],
    "password" => $_ENV["DB_PASS"],
    "charset" => "utf8",
    "collation" => "utf8_unicode_ci",
    "prefix" => "",
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();

require __DIR__ . '/../src/routes.php';

use Slim\Exception\HttpNotFoundException;
use Psr\Http\Message\ServerRequestInterface as Request;

$errorMiddleware = $app->addErrorMiddleware(true, true, true);
$errorMiddleware->setErrorHandler(HttpNotFoundException::class, function(
    Request $request,
    Throwable $exception,
    bool $displayErrorDetails
) use ($app) {
    $response = $app->getResponseFactory()->createResponse();
    $response->getBody()->write(json_encode([
        "error" => "Ruta no encontrada",
        "ruta" => (string)$request->getUri()
    ]));
    return $response->withHeader("Content-Type", "application/json")->withStatus(404);
});

$app->run();