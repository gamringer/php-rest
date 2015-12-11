<?php

namespace gamringer\PHPREST;

use \Psr\Http\Message\RequestInterface;
use \Psr\Http\Message\ResponseInterface;
use \GuzzleHttp\Psr7;
use \League\Container\Container;

class Kernel
{
    protected $environment;
    protected $router;
    protected $pathLocation = '';

    public function __construct(Environment $environment)
    {
        $this->environment = $environment;
    }

    public function setRouter($router)
    {
        $this->router = $router;
    }

    public function setPathLocation($pathLocation)
    {
        $this->pathLocation = $pathLocation;
    }

    public function getEnvironment()
    {
        return $this->environment;
    }

    public function getApplicationPath($path)
    {
        if (!empty($this->pathLocation)) {
            $path = preg_replace('#^'.$this->pathLocation.'#', '', $path);
        }

        return $path;
    }

    public function handle(RequestInterface $request)
    {
        $path = $this->getApplicationPath($request->getUri()->getPath());
        $resource = $this->router->route($path);
        var_dump($resource);
        exit;
        $response = new Psr7\Response(200, [
            'Content-Type' => 'application/json'
        ], 'salut');

        return $response;
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
}
