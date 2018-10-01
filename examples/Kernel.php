<?php

namespace gamringer\PHPREST\Example;

use \gamringer\PHPREST\Kernel as BaseKernel;
use \gamringer\PHPREST\Middlewares\RequestReroot;
use \gamringer\PHPREST\Middlewares\JDispatch;
use \gamringer\PHPREST\Middlewares\CatchAll;
use \gamringer\PHPREST\Router;
use \gamringer\PHPREST\Dispatcher;
use \League\Container\Container;

class Kernel extends BaseKernel
{
    public function initialize(): void
    {
        $this->container = new Container();

        $this->container->share('environment', $this->environment);
        $this->container->share('handler.root-get', '\gamringer\PHPREST\Example\Controllers\RootHandler');

        $this->container->addServiceProvider(new ServiceProvider());

        $root = FooAPI::getRoot();
        $router = new Router($root);
        $dispatcher = new \gamringer\PHPREST\ResourceDispatcher($router);
        $dispatcher->setContainer($this->container);

        $dispatcherMiddleware = new \gamringer\PHPREST\Middlewares\Dispatch(
            $dispatcher,
            new \gamringer\PHPREST\Example\Factories\ErrorResponseFactory()
        );

        $this->queueMiddleware($dispatcherMiddleware);
    }
}
