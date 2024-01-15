<?php

class Route
{

    private Router $router;
    private string $route;
    private string $method;
    private $handler;
    private $middleware;

    public function __construct(Router $router, string $route, string $method, callable $handler)
    {
        $this->router = $router;
        $this->route = $route;
        $this->method = $method;
        $this->handler = $handler;
    }

    public function getRouter(): Router
    {
        return $this->router;
    }

    public function setMiddleware($middleware): void
    {
        $this->middleware = $middleware;
    }

    public function getMiddleware(): ?callable
    {
        return $this->middleware;
    }
    public function getRoute(): string
    {
        return $this->route;
    }

    public function setRoute(string $route): void
    {
        $this->route = $route;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function setMethod(string $method): void
    {
        $this->method = $method;
    }

    public function getHandler(): callable
    {
        return $this->handler;
    }

    public function setHandler(callable $handler): void
    {
        $this->handler = $handler;
    }
}