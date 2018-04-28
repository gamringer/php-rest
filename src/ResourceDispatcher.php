<?php
declare(strict_types=1);

namespace gamringer\PHPREST;

use \Psr\Http\Message\RequestInterface;
use \GuzzleHttp\Psr7;
use \gamringer\PHPREST\Kernel;
use \League\Container\Container;
use \League\Container\ContainerAwareInterface;
use \League\Container\ContainerAwareTrait;
use \FastRoute;

class ResourceDispatcher implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function __construct($router)
    {
        $this->router = $router;
    }

    public function dispatch(RequestInterface $request)
    {
        $resource = $this->router->route($request->getUri()->getPath());
        $handlerName = $resource->getMethodHandler($request->getMethod());
        $handler = $this->container->get($handlerName);

        return $handler($request, $resource);
    }
}
