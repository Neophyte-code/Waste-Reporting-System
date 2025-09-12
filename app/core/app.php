<?php

class App
{
    protected $controller = 'Auth'; // Default controller
    protected $method = 'index'; // Default method
    protected $params = []; // Parameters

    public function __construct()
    {
        $url = $this->parseUrl();

        // Check if the first URL segment exists and if the controller file exists
        if (isset($url[0]) && file_exists('../app/controller/' . $url[0] . '.php')) {
            $this->controller = $url[0];
            unset($url[0]);
        }

        // Include the controller file
        require_once '../app/controller/' . $this->controller . '.php';

        // Initialize the controller object
        $this->controller = new $this->controller;

        // Check if the method exists in the controller
        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            } else {
                // Method doesn't exist, show 404
                $this->loadNotFound();
                return;
            }
        }

        // Set parameters
        $this->params = $url ? array_values($url) : [];

        // ✅ Check if parameter count is valid
        $reflection = new ReflectionMethod($this->controller, $this->method);
        $requiredParams = $reflection->getNumberOfRequiredParameters();
        $maxParams = $reflection->getNumberOfParameters();

        if (count($this->params) < $requiredParams || count($this->params) > $maxParams) {
            $this->loadNotFound();
            return;
        }

        // Call the method with the parameters
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    public function parseUrl()
    {
        if (isset($_GET['url'])) {
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
        return [];
    }

    private function loadNotFound()
    {
        require_once '../app/controller/PageError.php';
        $this->controller = new PageError();
        $this->method = 'notFound';
        $this->params = [];
        call_user_func([$this->controller, $this->method]);
    }
}
