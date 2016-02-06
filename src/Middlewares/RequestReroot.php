<?php

namespace gamringer\PHPREST\Middlewares;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Relay\MiddlewareInterface;

class RequestReroot implements MiddlewareInterface
{
    protected $location;

    public function __construct($location)
    {
        $this->location = $location;
    }

    public function __invoke (RequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        $path = preg_replace('#^'.$this->location.'#', '', $request->getUri()->getPath());
        $uri = $request->getUri()->withPath($path);

        return $next($request->withUri($uri), $response);
    }
}