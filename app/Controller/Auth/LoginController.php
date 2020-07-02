<?php


namespace App\Controller\Auth;


use App\Core\Controller;

class LoginController extends Controller
{
    public function index()
    {
        return $this->view("auth.login");
    }
}