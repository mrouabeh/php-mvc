<?php


namespace App\Controller;


use App\Core\Controller;

class HomeController extends Controller
{
    public function index()
    {
        return $this->view("index");
    }
}