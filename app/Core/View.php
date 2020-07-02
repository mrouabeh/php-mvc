<?php


namespace App\Core;


use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class View
{
    public function __construct()
    {
        $this->loader = new FilesystemLoader(ROOT_VIEW);
        $this->twig = new Environment($this->loader);
    }

    public function render($path, $params = null)
    {
        $viewPath = ROOT_VIEW . $path;
        if (file_exists($viewPath))
        {
            if ($params)
            {
                echo $this->twig->render($path, $params);
            }
            else
            {
                echo $this->twig->render($path);
            }
        }
    }
}