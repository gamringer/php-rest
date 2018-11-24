<?php
declare(strict_types=1);

namespace gamringer\PHPREST\RequestHandling\Providers;

use gamringer\PHPREST\RequestHandling\HandlerProviderInterface;
use gamringer\PHPREST\RequestHandling\RequestHandlerInterface;
use gamringer\PHPREST\Exceptions\RequestHandlingException;
use League\Container\ContainerAwareInterface;
use League\Container\ContainerAwareTrait;
use League\Container\ContainerInterface;

class ContainerHandlerProvider implements HandlerProviderInterface, ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function provide(string $handlerName): RequestHandlerInterface
    {
        $handler = $this->container->get($handlerName);

        if ($handler instanceof RequestHandlerInterface) {
            return $handler;
        }

        throw new RequestHandlingException("Handler $handlerName does not implement RequestHandlerInterface");
    }
}
