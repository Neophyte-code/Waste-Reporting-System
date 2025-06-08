<?php

class Announcement extends Controller
{

    public function index()
    {
        $this->view("announcement/index", []);
    }
}
