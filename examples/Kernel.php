<?php

namespace gamringer\PHPREST\Example;

use \gamringer\PHPREST\Kernel as BaseKernel;
use \gamringer\PHPREST\Middlewares\RequestReroot;
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

        $this->container->addServiceProvider(new ServiceProvider());

        $this->queueMiddleware($this->container->get('middleware.dispatch'));
    }
}
