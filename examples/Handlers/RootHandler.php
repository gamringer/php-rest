<?php

namespace gamringer\PHPREST\Example\Handlers;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use gamringer\PHPREST\Resources\Resource;
use gamringer\PHPREST\RequestHandling\RequestHandlerInterface;

class RootHandler implements RequestHandlerInterface
{
    protected $responseFactory;
    protected $streamFactory;

    public function __construct(ResponseFactoryInterface $responseFactory, StreamFactoryInterface $streamFactory)
    {
        $this->responseFactory = $responseFactory;
        $this->streamFactory = $streamFactory;
    }

    public function handle(ServerRequestInterface $request, Resource $resource): ResponseInterface
    {
        return $this->responseFactory
            ->createResponse(200)
            ->withHeader('Content-Type', 'text/plain')
            ->withBody($this->streamFactory->createStream('This is the API Root!'))
        ;
    }
}
