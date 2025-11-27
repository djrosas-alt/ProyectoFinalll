<?php

use Slim\Factory\AppFactory;
use DI\Container;
use Illuminate\Database\Capsule\Manager as Capsule;

require _DIR_ . '/../vendor/autoload.php';


$container = new Container();
AppFactory::setContainer($container);

$app = AppFactory::create();


$app->add(function ($req, $handler) {
    $res = $handler->handle($req);
    return $res
        ->withHeader("Access-Control-Allow-Origin", "*")
        ->withHeader("Access-Control-Allow-Headers", "Content-Type, Authorization")
        ->withHeader("Access-Control-Allow-Methods", "GET, POST, PUT, DELETE, OPTIONS");
});


$dotenv = Dotenv\Dotenv::createImmutable(_DIR_ . '/../');
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


require _DIR_ . '/../src/routes.php';

$app->run();