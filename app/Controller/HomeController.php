<?php


namespace App\Controller;


use App\Core\Controller;

class HomeController extends Controller
{
    public function index()
    {
        return $this->view("index.html.twig");
    }

    public function show()
    {
        $page = "/home";
        return $this->view('show.html.twig', ['page' => $page]);
    }
}