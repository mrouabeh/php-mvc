<?php


namespace App\Core;


abstract class Controller
{
    public function view($path, $params = null)
    {
        $view = new View();
        if ($params)
        {
            $view->render($path, $params);
        }
        else
        {
            $view->render($path);
        }
    }
}