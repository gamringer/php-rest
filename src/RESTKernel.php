<?php

namespace gamringer\PHPREST;

use \Psr\Http\Message\RequestInterface;
use \Psr\Http\Message\ResponseInterface;
use \GuzzleHttp\Psr7;
use \League\Container\Container;

class RESTKernel extends Kernel
{
    public function handle(RequestInterface $request)
    {
        return $this->dispatcher->dispatch($request);
    }
}
