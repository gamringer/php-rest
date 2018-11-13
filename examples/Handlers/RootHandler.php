<?php

namespace gamringer\PHPREST\Example\Handlers;

use \Psr\Http\Message\RequestInterface;
use \Psr\Http\Message\ResponseFactoryInterface;
use \Psr\Http\Message\StreamFactoryInterface;
use \GuzzleHttp\Psr7;
use \gamringer\PHPREST\Resources\Resource;

class RootHandler
{
    protected $responseFactory;
    protected $streamFactory;

    public function __construct(ResponseFactoryInterface $responseFactory, StreamFactoryInterface $streamFactory)
    {
        $this->responseFactory = $responseFactory;
        $this->streamFactory = $streamFactory;
    }

    public function __invoke(RequestInterface $request, Resource $resource)
    {
        return $this->responseFactory
            ->createResponse(200)
            ->withHeader('Content-Type', 'text/plain')
            ->withBody($this->streamFactory->createStream('This is the API Root!'))
        ;
    }
}
