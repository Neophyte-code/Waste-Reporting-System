<?php

class Controller
{

    public function model($model)
    {

        require_once __DIR__ . '/../model/' . $model . '.php';
        return new $model();
    }

    public function view($view, $data)
    {
        require_once __DIR__ . '/../view/' . $view . '.php';
    }

    //function to check the authorize role
    public function authorize($roles = [])
    {
        if (!isset($_SESSION['user']['role']) || !in_array($_SESSION['user']['role'], $roles)) {
            header('Location: ' . URL_ROOT . '/PageError/forbidden');
            exit;
        }
    }
}
