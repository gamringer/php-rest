<?php

namespace gamringer\PHPREST\Middlewares;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Telegraph\MiddlewareInterface;

class Session implements MiddlewareInterface
{
    protected $store;

    public function __construct($store)
    {
        $this->store = $store;
    }

    public function __invoke (RequestInterface $request, callable $next = null)
    {
        return $this->dispatcher->dispatch($request);
    }
}
