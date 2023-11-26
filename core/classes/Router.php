<?php

class Router
{

    private array $routes = [];
    private array $middlewares = [];
    private string $base;

    /**
     * @param string $base
     */
    public function __construct(string $base = "")
    {
        $this->base = $base;
    }

    public function addRoute(string $route, $handler, string $method = "GET"): Router
    {
        if (substr($route, -1) == '/')
            $route = substr($route, 0, -1);

        $this->routes[$method][$route] = $handler;
        return $this;
    }

    public function get(string $route, $handler): Router
    {
        return $this->addRoute($route, $handler);
    }

    public function post(string $route, $handler): Router
    {
        return $this->addRoute($route, $handler, "POST");
    }

    public function put(string $route, $handler): Router
    {
        return $this->addRoute($route, $handler, "PUT");
    }

    public function delete(string $route, $handler): Router
    {
        return $this->addRoute($route, $handler, "DELETE");
    }

    public function middleware($handler): Router
    {
        end($this->routes);
        $route = key($this->routes);
        $this->middlewares[$route] = $handler;
        return $this;
    }

    public function removeRoute(string $route, string $method = "GET"): void
    {
        unset($this->routes[$method][$route]);
    }

    private function getRoute(string $route)
    {
        return $this->routes[$route];
    }

    public function toURL($url): string
    {
        return $this->base . "/" . (trim($url, "/"));
    }

    public function isCurrent($href): bool
    {
        $requestedUrl = $this->getRequestURI();
        $url = strtolower(preg_replace("#^" . preg_quote($this->base, '#') . "#", "", $requestedUrl));
        return $url == $href;
    }

    public function getRequestURI(): string
    {
        $requestedUrl = $_SERVER['REQUEST_URI'];
        if (substr($requestedUrl, -1) == '/')
            $requestedUrl = substr($requestedUrl, 0, -1);
        $url = preg_replace("#^" . preg_quote($this->base, '#') . "#", "", $requestedUrl);
        return preg_replace('/\?.*/', '', $url);
    }

    public function dispatch(): bool
    {
        $url = $this->getRequestURI();

        $method = $_SERVER['REQUEST_METHOD'];

//        echo $method;
//        exit;

        if(!isset($this->routes[$method]))
            return false;

        foreach ($this->routes[$method] as $route => $callback) {
            $pattern = str_replace('/', '\/', $route);
            $pattern = '#^' . preg_replace('/\{([a-zA-Z]+)\}/', '(?<$1>[^\/]+)', $pattern) . '$#';

            if (preg_match($pattern, $url, $matches)) {
                $params = array_intersect_key($matches, array_flip(array_filter(array_keys($matches), 'is_string')));
                if (!empty($this->middlewares[$route]))
                    call_user_func_array($this->middlewares[$route], [$params]);
                call_user_func_array($callback, [$params]);
                return true;
            }
        }
        return false;
    }

    public function redirect($url): void
    {
        header("Location: " . $this->toURL($url));
    }
}