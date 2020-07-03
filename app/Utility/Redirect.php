<?php


namespace App\Utility;


use App\Core\View;

class Redirect
{
    public static function to($location = "") {
        if ($location) {
            if ($location === 404) {
                $view = new View();
                header('HTTP/1.0 404 Not Found');
                $view->render('template.404');
            } else {
                header("Location: " . $location);
            }
            exit();
        }
    }

}
