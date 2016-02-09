<?php

namespace gamringer\PHPREST\Middlewares;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Relay\MiddlewareInterface;
use \GuzzleHttp\Psr7;

class CatchAll implements MiddlewareInterface
{
    public function __invoke (RequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        try {
            return $next($request, $response);
        } catch (\Exception $e) {
            return new Psr7\Response(500, [], 'error');
        }
    }
}