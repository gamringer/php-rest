<?php

namespace gamringer\PHPREST\Middlewares;

use \Psr\Http\Message\ResponseInterface;
use \Psr\Http\Message\ServerRequestInterface;
use \Psr\Http\Server\MiddlewareInterface;
use \Psr\Http\Server\RequestHandlerInterface;

class RequestReroot implements MiddlewareInterface
{
    protected $location;

    public function __construct($location)
    {
        $this->location = $location;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $path = preg_replace('#^'.$this->location.'#', '', $request->getUri()->getPath());
        $uri = $request->getUri()->withPath($path);

        return $handler->handle($request->withUri($uri));
    }
}
