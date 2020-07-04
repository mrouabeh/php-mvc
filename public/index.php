<?php

require dirname(__DIR__) . "/vendor/autoload.php";
require dirname(__DIR__) . "/config/app.php";
require dirname(__DIR__) . "/config/database.php";

use App\Core\Router;

$router = new Router;

$router->get('/', "HomeController@index");

$router->run();