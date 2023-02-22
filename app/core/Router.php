<?php

namespace app\core;

class Router
{
    public $routes = [];
    private $uri;
    private $httpMethod;

    public function __construct()
    {
        $this->uri = $this->getUri();
        $this->httpMethod = $this->getHttpMethod();
    }

    public static function getUri() : string
    {
        return parse_url(trim($_SERVER['REQUEST_URI']))['path'];
    }
 
    public function getHttpMethod() : string
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function get($path, $controller)
    {
        $this->request('get', $path, $controller);
    }

    public function post($path, $controller)
    {
        $this->request('post', $path, $controller);
    }

    private function request($method, $path, $controller)
    {
        $this->routes[$method][$path] = $controller;
    }
        
    public function run() : string
    {
        if (array_key_exists($this->uri, $this->routes[$this->httpMethod])) {
            $controllerName = 'app\\controllers\\' . $this->routes[$this->httpMethod][$this->uri][0];
            $controllerMethod = $this->routes[$this->httpMethod][$this->uri][1];
            $content = $controllerName::$controllerMethod();
        } else {
            header('HTTP/1.0 404 Not Found');
            $content = 'Error 404. Page not found.';
        }
        return $content;
    }

    public static function redirect($path)
    {
        header('Location: ' . $path);
        exit;
    }
}
