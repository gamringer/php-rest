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
    ];

    public function register()
    {
        $container = $this->getContainer();

        $this->container->share('api-root', '\gamringer\PHPREST\Example\FooAPI');
        $this->container->share('api-router', '\gamringer\PHPREST\Router')
            ->withArguments(['api-root'])
        ;
        $this->container->share('api-dispatcher', '\gamringer\PHPREST\ResourceDispatcher')
            ->withArguments(['api-router', $container])
        ;

        $this->container->share('error-factory', '\gamringer\PHPREST\Example\Factories\ErrorResponseFactory');

        $this->container->share('middleware.dispatch', '\gamringer\PHPREST\Middlewares\Dispatch')
            ->withArguments(['api-dispatcher', 'error-factory'])
        ;

        $this->container->share('handler.root-get', '\gamringer\PHPREST\Example\Handlers\RootHandler');
    }
}
