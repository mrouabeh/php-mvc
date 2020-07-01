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
        $path = preg_replace();
    }

    public function execute()
    {
        
    }
}