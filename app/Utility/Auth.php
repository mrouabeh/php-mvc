<?php


namespace App\Utility;


class Auth
{
    public static function checkAuthenticated($redirection = "/login")
    {
        Session::init();
        if (!Session::exists('user'))
        {
            Session::destroy();
            Redirect::to($redirection);
        }
    }

    public static function checkUnauthenticated($redirection = "")
    {
        Session::init();
        if (Session::exists('user'))
        {
            Redirect::to($redirection);
        }
    }
}