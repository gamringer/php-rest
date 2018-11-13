<?php

namespace gamringer\PHPREST\Middlewares;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use gamringer\PHPREST\Exceptions\ResourceNotFoundException;
use gamringer\PHPREST\Exceptions\MethodNotSupportedException;

class Dispatch implements MiddlewareInterface
{
    protected $dispatcher;
    protected $errorFactory;

    public function __construct(RequestHandlerInterface $dispatcher, $errorFactory)
    {
        $this->dispatcher = $dispatcher;
        $this->errorFactory = $errorFactory;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            return $this->dispatcher->handle($request);
        } catch (ResourceNotFoundException $e) {
            return $this->errorFactory->produceResourceNotFound();
        } catch (MethodNotSupportedException $e) {
            return $this->errorFactory->produceMethodNotSupported($e->getResource());
        }
    }
}
