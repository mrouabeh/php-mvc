<?php


namespace App\Core;


class Controller
{
    public function __construct()
    {
        $this->view = new View();
    }

    public function view($file, $params = null)
    {
        $path = str_replace(".", "/", $file);
        $path .= ".html.twig";
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