<?php

declare(strict_types=1);

namespace gamringer\PHPREST;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use gamringer\Pipe\Pipe;

class Kernel
{
    protected $pipe;
    protected $environment;
    protected $middlewares = [];

    public function __construct(Environment $environment)
    {
        $this->pipe = new Pipe();

        $this->environment = $environment;

        $this->initialize();
    }

    public function getEnvironment(): Environment
    {
        return $this->environment;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
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
