<?php

declare(strict_types=1);

namespace app;

class Router
{
    public function __construct(private array $routes = [])
    {
    }

    public function addRoute(string $route, callable $function): static
    {
        $this->routes[$route] = $function;

        return $this;
    }

    public function route($route, $params = [])
    {
        if (isset($this->routes[$route])) {
            return $this->routes[$route](...$params);
        } else {
            throw new \Exception("Route '$route' not found");
        }
    }

    public function parseQueryString()
    {
        if (isset($_GET['route'])) {
            $parts = explode('/', $_GET['route']);
            $baseRoute = array_shift($parts);
            $params = $parts;
            return $this->route($baseRoute, $params);
        } else {
            return $this->route('/');
        }
    }
}
