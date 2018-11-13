<?php
declare(strict_types=1);

namespace gamringer\PHPREST;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;
use League\Container\ContainerAwareInterface;
use League\Container\ContainerAwareTrait;

class ResourceDispatcher implements ContainerAwareInterface, RequestHandlerInterface
{
    use ContainerAwareTrait;

    protected $router;

    public function __construct($router, $container)
    {
        $this->router = $router;
        $this->container = $container;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $resource = $this->router->route($request->getUri()->getPath());
        $handlerName = $resource->getMethodHandler($request->getMethod());
        $handler = $this->container->get($handlerName);

        return $handler($request, $resource);
    }
}
