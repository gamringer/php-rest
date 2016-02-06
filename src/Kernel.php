<?php

namespace gamringer\PHPREST;

use \Psr\Http\Message\RequestInterface;
use \Psr\Http\Message\ResponseInterface;
use \Relay\MiddlewareInterface;
use \Relay\RelayBuilder;
use \GuzzleHttp\Psr7;
use \League\Container\Container;

class Kernel
{
    protected $environment;
    protected $dispatcher;
    protected $middlewares = [];
    protected $relay;

    public function __construct(Environment $environment)
    {
        $this->environment = $environment;

        $this->init();

        $this->relay = (new RelayBuilder())->newInstance($this->middlewares);
    }

    public function setDispatcher($dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function getEnvironment()
    {
        return $this->environment;
    }

    public function handle(RequestInterface $request)
    {
        return $this->relay->__invoke($request, new Psr7\Response());
    }

    public function send(ResponseInterface $response)
    {
        http_response_code($response->getStatusCode());

        foreach ($response->getHeaders() as $header => $values) {
            foreach ($values as $value) {
                header($header . ':' . $value, false);
            }
        }
        
        Psr7\copy_to_stream($response->getBody(), $this->environment->getStdOut());
    }

    public function shutdown()
    {
        
    }

    protected function queueMiddleware(MiddlewareInterface $middleware)
    {
        $this->middlewares[] = $middleware;
    }
}
