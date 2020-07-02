<?php


namespace App\Core;


class Controller
{
    public function __construct()
    {
        $this->view = new View();
    }

    public function view($path, $params = null)
    {
        if ($params)
        {
            $this->view->render($path, $params);
        }
        else
        {
            $this->view->render($path);
        }
    }
}