<?php

namespace gamringer\PHPREST;

use \gamringer\JSONPointer\Pointer;
use \Psr\Http\Message\RequestInterface;
use \GuzzleHttp\Psr7;
use \League\Container\ContainerAwareInterface;
use \League\Container\ContainerAwareTrait;

class JPDispatcher
{
    use ContainerAwareTrait;

    protected $router;
    protected $resourceControllers = [];

    public function __construct(JPRouter $router)
    {
        $this->router = $router;
    }

    public function defineController($method, $model, $serviceCallable)
    {
        $this->resourceControllers[$model][$method] = $serviceCallable;
    }

    public function dispatch(RequestInterface $request)
    {
        $path = $request->getUri()->getPath();

        $resource = $this->router->route($path);

        $resourceFQCN = get_class($resource);
        
        if (!array_key_exists($resourceFQCN, $this->resourceControllers)) {
            throw new Exception('Routed resource not handled');
        }
        if (!array_key_exists($request->getMethod(), $this->resourceControllers[$resourceFQCN])) {
            throw new Exception('Method not handled for the routed resource');
        }

        $serviceCallable = $this->resourceControllers[$resourceFQCN][$request->getMethod()];
        if (
            isset($this->container)
         && preg_match('/([\w-]*)::(\w*)/', $serviceCallable, $matches)
         && $this->container->has($matches[1])
        ) {
            $serviceCallable = [$this->container->get($matches[1]), $matches[2]];
        }

        return $serviceCallable($request, $resource);
    }
}
