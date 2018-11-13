<?php

declare(strict_types=1);

namespace gamringer\PHPREST;

use \Psr\Http\Message\RequestInterface;
use \Psr\Http\Message\ResponseInterface;
use \Psr\Http\Server\MiddlewareInterface;
use \Psr\Http\Server\RequestHandlerInterface;
use \GuzzleHttp\Psr7;

class Kernel
{
    protected $environment;
    protected $middlewares = [];

    public function __construct(Environment $environment)
    {
        $this->pipe = new \gamringer\Pipe\Pipe();

        $this->environment = $environment;

        $this->initialize();

    }

    public function getEnvironment(): Environment
    {
        return $this->environment;
    }

    public function handle(RequestInterface $request): ResponseInterface
    {
        return $this->pipe->handle($request);
    }

    public function initialize(): void
    {

    }

    public function shutdown(): void
    {

    }

    protected function queueMiddleware(MiddlewareInterface $middleware): void
    {
        $this->pipe->push($middleware);
    }
}
