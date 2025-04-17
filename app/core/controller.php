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
}
