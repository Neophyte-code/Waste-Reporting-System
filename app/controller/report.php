<?php

class Report extends Controller
{

    public function waste()
    {
        $this->view("report/waste", []);
    }

    public function litterer()
    {
        $this->view("report/litterer", []);
    }
}
