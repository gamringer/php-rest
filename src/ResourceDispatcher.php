<?php

declare(strict_types=1);

namespace gamringer\PHPREST;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;
use gamringer\PHPREST\RequestHandling\HandlerProviderInterface;
use gamringer\PHPREST\Routing\ResourceRouterInterface;

class ResourceDispatcher implements RequestHandlerInterface
{
    protected $router;
    protected $handlerProvider;

    public function __construct(ResourceRouterInterface $router, HandlerProviderInterface $handlerProvider)
    {
        $this->router = $router;
        $this->handlerProvider = $handlerProvider;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $resource = $this->router->route($request);
        $handlerName = $resource->getMethodHandler($request->getMethod());
        $handler = $this->handlerProvider->provide($handlerName);

        return $handler->handle($request, $resource);
    }
}
