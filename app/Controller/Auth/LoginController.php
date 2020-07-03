<?php


namespace App\Controller\Auth;


use App\Core\Controller;
use App\Utility\Redirect;

class LoginController extends Controller
{
    public function index()
    {
        return $this->view("auth.login");
    }

    public function login()
    {

    }

    public function checkUser()
    {
        
    }
}