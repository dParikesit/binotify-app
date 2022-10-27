<?php

namespace App\Router;
use App\Utils\PUTParser;

class Router
{
    private $namespace = '';
    private $routeList = [];
    private $notFoundView = null;
    private $acceptedHttpMethods = ['GET', 'POST', 'PUT', 'PATCH', 'DELETE'];
    private $httpMethod = 'GET';
    private $route = [];

    private function request_path()
    {
        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }

    private function requestMethod() : string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    private function checkHttpMethod()
    {
        $this->httpMethod = $this->requestMethod();

        $path = substr($this->request_path(),1);

        if(!isset($this->routeList[$path][$this->httpMethod])){
            return false;
        }

        $this->route = $this->routeList[$path][$this->httpMethod];
        return true;
    }

    private function createRoute(string $httpMethod, string $path, callable $function)
    {
        $route = array();
        $route["path"] = substr($path,1);
        $route["http_method"] = $httpMethod;
        $route["function"] = $function;

        return $route;
    }

    private function setRoute(array $route) : void
    {
        $this->routeList[$route["path"]][$route["http_method"]] = $route;
    }

    public function notFoundView(string $view) : void
    {
        $this->notFoundView = $view;
    }

    public function run()
    {
        try {
            // Check http verb of current request
            if(!$this->checkHttpMethod()) {
                // Exception
                http_response_code(404);
                if(!$this->notFoundView) {
                    header("HTTP/1.0 404 Not Found");
                    throw new \Exception('404 Not Found');
                    exit();
                }
                include $this->notFoundView;
                exit();
            }

            if ($this->httpMethod=="PUT"){
                PUTParser::parsePut();
            }

            // Defining controller and method
            $functionName = $this->route['function'];
        
            return $functionName();
            
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function registerRoute(string $httpMethod, string $path, callable $function)
    {
        // Creating route
        $route = $this->createRoute($httpMethod, $path, $function);
        $this->setRoute($route);
    }

    public function get(string $path, callable $function)
    {
        $this->registerRoute('GET', $path, $function);
    }

    public function post(string $path, callable $function)
    {
        $this->registerRoute('POST', $path, $function);
    }

    public function put(string $path, callable $function)
    {
        $this->registerRoute('PUT', $path, $function);
    }

    public function patch(string $path, callable $function)
    {
        $this->registerRoute('PATCH', $path, $function);
    }

    public function delete(string $path, callable $function)
    {
        $this->registerRoute('DELETE', $path, $function);
    }
}