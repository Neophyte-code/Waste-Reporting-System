<?php

class AuthController extends Controller
{

    public function index()
    {
        $this->view("auth/index", []);
    }
}
