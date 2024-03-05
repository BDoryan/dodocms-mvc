<?php

class Router
{

    private array $routes = [];
    private string $base;
    private array $replacer = [];

    private $notFoundHandler;

    /**
     * @param string $base
     */
    public function __construct(string $base = "")
    {
        $this->base = $base;
    }

    /**
     * @param array $replacer
     */
    public function setReplacer(array $replacer): void
    {
        $this->replacer = $replacer;
    }

    public function setNotFoundHandler($handler): void
    {
        $this->notFoundHandler = $handler;
    }

    public function addRoute(string $route, $handler, string $method = "GET"): Route
    {
        if (substr($route, -1) == '/')
            $route = substr($route, 0, -1);

        $route = str_replace(array_keys($this->replacer), array_values($this->replacer), $route);

        $route_ = new Route($this, $route, $method, $handler);
        $this->routes[$method][$route] = $route_;
        return $route_;
    }

    public function get(string $route, $handler): Route
    {
        return $this->addRoute($route, $handler);
    }

    public function post(string $route, $handler): Route
    {
        return $this->addRoute($route, $handler, "POST");
    }

    public function put(string $route, $handler): Route
    {
        return $this->addRoute($route, $handler, "PUT");
    }

    public function delete(string $route, $handler): Route
    {
        return $this->addRoute($route, $handler, "DELETE");
    }

    public function middleware($handler, ...$routes): Router
    {
        /** @var Route $route */
        foreach ($routes as $route) {
            $route->setMiddleware($handler);
        }
        return $this;
    }

    public function removeRoute(string $route, string $method = "GET"): void
    {
        $route = str_replace(array_keys($this->replacer), array_values($this->replacer), $route);
        unset($this->routes[$method][$route]);
    }

    private function getRoute(string $route)
    {
        return $this->routes[$route];
    }

    public function toURL($url): string
    {
        $url = str_replace(array_keys($this->replacer), array_values($this->replacer), $url);
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

        $url = preg_replace("#^" . preg_quote($this->base, '#') . "#", "", $requestedUrl);
        $url = preg_replace('/\?.*/', '', $url);
        if (substr($url, -1) == '/')
            $url =  substr($url, 0, -1);
        return $url;
    }

    public function dispatch(): bool
    {
        $url = $this->getRequestURI();

        $method = $_SERVER['REQUEST_METHOD'];

        if(!isset($this->routes[$method]))
            return false;

        /** @var Route $route */
        foreach ($this->routes[$method] as $route) {
            $pattern = str_replace('/', '\/', $route->getRoute());
            $pattern = '#^' . preg_replace('/\{([a-zA-Z]+)\}/', '(?<$1>[^\/]+)', $pattern) . '$#';

            if (preg_match($pattern, $url, $matches)) {
                $params = array_intersect_key($matches, array_flip(array_filter(array_keys($matches), 'is_string')));
                $continue = true;

                if ($route->getMiddleware() !== null)
                    $continue = call_user_func_array($route->getMiddleware(), [$params]);

                if($continue)
                    call_user_func_array($route->getHandler(), [$params]);
                return true;
            }
        }

        if ($this->notFoundHandler !== null)
            call_user_func_array($this->notFoundHandler, []);

        return false;
    }

    public function redirect($url): void
    {
        header("Location: " . $this->toURL($url));
    }

    /**
     * @return array
     */
    public function getReplacer(): array
    {
        return $this->replacer;
    }
}