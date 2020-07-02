<?php

require dirname(__DIR__) . "/vendor/autoload.php";
require dirname(__DIR__) . "/config/app.php";
require dirname(__DIR__) . "/config/database.php";

use App\Core\Router;

$router = new Router;

$router->get('/', "HomeController@index");

$router->get('/login', 'Auth\LoginController@index');
$router->post('/login', 'Auth\LoginController@login');

$router->get('/register', 'Auth\RegisterController@index');
$router->post('/register', 'Auth\RegisterController@login');

$router->run();