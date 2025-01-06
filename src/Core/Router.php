<?php

namespace Core;

class Router
{
    private array $routes = [];

    public function add(string|array $path, array $handler): void
    {
        if(is_array($path)){
            foreach($path as $p){
                if(is_string($p)) $this->routes[$p] = $handler;
            }
        }else{
            $this->routes[$path] = $handler;
        }
    }

    public function dispatch(string $uri): void
    {
        $uri = parse_url($uri, PHP_URL_PATH);
        if (array_key_exists($uri, $this->routes)) {
            [$class, $method] = $this->routes[$uri];
            $controller = new $class();
            $controller->$method();
        } else {
            http_response_code(404);
            echo "404 Not Found";
        }
    }
}

?>