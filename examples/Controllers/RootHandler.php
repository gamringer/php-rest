<?php

namespace gamringer\PHPREST\Example\Controllers;

use \Psr\Http\Message\RequestInterface;
use \GuzzleHttp\Psr7;
use \gamringer\PHPREST\Resources\Resource;

class RootHandler
{
    public function __invoke(RequestInterface $request, Resource $resource)
    {
        return new Psr7\Response(200, ['Content-Type' => 'text/html'], 'This is the API Root!');
    }
}
