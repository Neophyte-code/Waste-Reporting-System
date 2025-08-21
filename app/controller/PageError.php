<?php

class PageError extends Controller
{
    public function forbidden()
    {
        http_response_code(403);
        $this->view('errors/403', []);
    }

    public function notFound()
    {
        http_response_code(404);
        $this->view('errors/404', []);
    }
}
