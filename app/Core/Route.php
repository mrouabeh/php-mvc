<?php


namespace App\Core;


class Route
{
    public $uri;
    public $action;
    public $matches = [];

    public function __construct($uri, $action)
    {
        $this->uri = trim($uri, "/");
        $this->action = $action;
    }

    public function matches($uri)
    {
        $path = preg_replace("#:([\w]+)#", "([^/]+)", $this->uri);
        $pathToMatch = "#^$path$#";

        if (preg_match($pathToMatch, $uri, $matches))
        {
            $this->matches = $matches;
            return true;
        }

        return false;
    }

    public function execute()
    {
        $action = explode('@', $this->action);

        if (isset($action[0], $action[1]))
        {
            $className = $this->_getClassName($action[0]);
            if (class_exists($className))
            {
                $controller = new $className();
                $method = $action[1];
                if (method_exists($controller, $method))
                {
                    if (isset($this->matches[1]))
                    {
                        $params = array_slice($this->matches, 1);
                        $controller->$method(...$params);
                    }
                    else
                    {
                        $controller->$method();
                    }
                }
                else
                    throw new \Exception("Method doesn't exist");
            }
            else
                throw new \Exception("Class {$className} doesn't exist");
        }
        else
        {
            throw new \Exception("The action doesn't exist");
        }
    }

    private function _getClassName($className)
    {
        if (!preg_match("#^(App\\Controller)#", $className))
        {
            $className = "App\\Controller\\" . $className;
        }

        return ($className);
    }
}