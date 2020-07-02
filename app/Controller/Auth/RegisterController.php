<?php


namespace App\Controller\Auth;


use App\Core\Controller;

class RegisterController extends Controller
{
    public function index()
    {
        return $this->view("auth.register");
    }
}