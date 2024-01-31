<?php

interface Routable {

    public function routes(Router $router): void;

}