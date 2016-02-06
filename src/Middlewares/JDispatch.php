<?php

namespace gamringer\PHPREST\Middlewares;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Relay\MiddlewareInterface;

class JDispatch implements MiddlewareInterface
{
    protected $location;
    protected $dispatcher;

    public function __construct($dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function __invoke (RequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        $response = $this->dispatcher->dispatch($request);

        return $next($request, $response);
    }
}