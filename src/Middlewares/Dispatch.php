<?php

namespace gamringer\PHPREST\Middlewares;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Telegraph\MiddlewareInterface;
use gamringer\PHPREST\Exceptions\MethodNotSupportedException;
use gamringer\PHPREST\Exceptions\ResourceNotFoundException;

class Dispatch implements MiddlewareInterface
{
    protected $dispatcher;
    protected $errorFactory;

    public function __construct($dispatcher, $errorFactory)
    {
        $this->dispatcher = $dispatcher;
        $this->errorFactory = $errorFactory;
    }

    public function __invoke (RequestInterface $request, callable $next = null)
    {
    	try {
        	return $this->dispatcher->dispatch($request);
        } catch (ResourceNotFoundException $e) {
        	return $this->errorFactory->produceResourceNotFound();
        } catch (MethodNotSupportedException $e) {
        	return $this->errorFactory->produceMethodNotSupported($e->getResource());
        }
    }
}
