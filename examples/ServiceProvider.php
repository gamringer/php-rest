<?php

namespace gamringer\PHPREST\Example;

use League\Container\ServiceProvider\AbstractServiceProvider;

class ServiceProvider extends AbstractServiceProvider
{
    protected $provides = [
        'api-root',
        'api-router',
        'api-dispatcher',
        'handler.root-get',
        'middleware.dispatch',
        'middleware.catchall',
    ];

    public function register()
    {
        $container = $this->getContainer();

        $this->container->share('api-root', '\gamringer\PHPREST\Example\FooAPI');
        $this->container->share('api-router', '\gamringer\PHPREST\Routing\Routers\JsonPointerRouter')
            ->withArguments(['api-root'])
        ;
        $this->container->share('handler-provider', \gamringer\PHPREST\RequestHandling\Providers\ContainerHandlerProvider::class)
            ->withArguments([$container])
        ;
        $this->container->share('api-dispatcher', '\gamringer\PHPREST\ResourceDispatcher')
            ->withArguments(['api-router', 'handler-provider'])
        ;

        $this->container->share('http.response-factory', '\Http\Factory\Guzzle\ResponseFactory');
        $this->container->share('http.stream-factory', '\Http\Factory\Guzzle\StreamFactory');
        $this->container->share('error-factory', '\gamringer\PHPREST\Example\Factories\ErrorResponseFactory');

        $this->container->share('middleware.dispatch', '\gamringer\PHPREST\Middlewares\Dispatch')
            ->withArguments(['api-dispatcher', 'error-factory'])
        ;

        $this->container->share('middleware.catchall', '\gamringer\PHPREST\Middlewares\CatchAll')
            ->withArguments(['handler.error', 'logger'])
        ;
        $this->container->share('log-handler', '\Monolog\Handler\NullHandler');
        $this->container->share('logger', '\Monolog\Logger')
            ->withArguments(['main-logger'])
            ->withMethodCall('pushHandler', ['log-handler'])
        ;

        $this->container->share('handler.root-get', '\gamringer\PHPREST\Example\Handlers\RootHandler')
            ->withArguments(['http.response-factory', 'http.stream-factory'])
        ;
        $this->container->share('handler.error', '\gamringer\PHPREST\Example\Handlers\ErrorHandler')
            ->withArguments(['http.response-factory', 'http.stream-factory'])
        ;
    }
}
