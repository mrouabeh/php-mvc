<?php


namespace App\Core;


class Router
{
    public $uri;
    public $routes = [];

    public function __construct()
    {
        $this->uri = trim($_SERVER['REQUEST_URI'], "/");
    }

    public function get(string $uri, string $action)
    {
        $this->routes['GET'][] = new Route($uri, $action);
    }

    public function head(string $uri, string $action)
    {
        $this->routes['HEAD'][] = new Route($uri, $action);
    }

    public function post(string $uri, string $action)
    {
        $this->routes['POST'][] = new Route($uri, $action);
    }

    public function patch(string $uri, string $action)
    {
        $this->routes['PATCH'][] = new Route($uri, $action);
    }

    public function put(string $uri, string $action)
    {
        $this->routes['PUT'][] = new Route($uri, $action);
    }

    public function delete(string $uri, string $action)
    {
        $this->routes['DELETE'][] = new Route($uri, $action);
    }

    public function run()
    {
        foreach ($this->routes[$_SERVER['REQUEST_METHOD']] as $route)
        {
            if ($route->matches($this->uri))
            {
                $route->execute();
//                return header
            }
        }

        header("HTTP/1.0 404 Not Found");
    }
}