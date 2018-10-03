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

    public function send(ResponseInterface $response): void
    {
        http_response_code($response->getStatusCode());

        foreach ($response->getHeaders() as $header => $values) {
            foreach ($values as $value) {
                header($header . ': ' . $value, false);
            }
        }

        $size = $response->getBody()->getSize();
        if ($size > 0) {
            header('Content-Length: ' . $size);
        }
        Psr7\copy_to_stream($response->getBody(), $this->environment->getStdOut());
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
