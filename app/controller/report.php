<?php

class Report extends Controller
{

    public function waste()
    {
        $this->view("report/waste", []);
    }

    public function literrer()
    {
        $this->view("report/litterer", []);
    }
}
