<?php

namespace gamringer\PHPREST\Middlewares;

use \Psr\Http\Message\ResponseInterface;
use \Psr\Http\Message\ServerRequestInterface;
use \Psr\Http\Server\MiddlewareInterface;
use \Psr\Http\Server\RequestHandlerInterface;

class RequestReroot implements MiddlewareInterface
{
    protected $location;

    public function __construct(string $location)
    {
        $this->location = $location;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $path = preg_replace('/^'.preg_quote($this->location, '/').'/', '', $request->getUri()->getPath());
        if ($path !== null) {
            $uri = $request->getUri()->withPath($path);
            $request = $request->withUri($uri);
        }
        
        return $handler->handle($request);
    }
}
