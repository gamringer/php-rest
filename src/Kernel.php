<?php

declare(strict_types=1);

namespace gamringer\PHPREST;

use \Psr\Http\Message\RequestInterface;
use \Psr\Http\Message\ResponseInterface;
use \GuzzleHttp\Psr7;
use \Telegraph;
use \Telegraph\MiddlewareInterface;
use \Telegraph\DispatcherInterface;

class Kernel
{
    protected $environment;
    protected $middlewares = [];

    public function __construct(Environment $environment)
    {
        $this->environment = $environment;

        $this->initialize();

        $this->setDispatcher(new Telegraph\Dispatcher($this->middlewares));
    }

    public function setDispatcher(DispatcherInterface $dispatcher): void
    {
        $this->dispatcher = $dispatcher;
    }

    public function getEnvironment(): Environment
    {
        return $this->environment;
    }

    public function handle(RequestInterface $request): ResponseInterface
    {
        return $this->dispatcher->dispatch($request);
    }

    public function send(ResponseInterface $response): void
    {
        http_response_code($response->getStatusCode());

        foreach ($response->getHeaders() as $header => $values) {
            foreach ($values as $value) {
                header($header . ': ' . $value, false);
                $this->container->get('logger-error')->debug('Setting Header: '.$header);
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
        $this->middlewares[] = $middleware;
    }
}
