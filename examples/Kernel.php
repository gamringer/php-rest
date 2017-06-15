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
    public function init()
    {
        $container = new Container();
        $container->addServiceProvider(new ServiceProvider());
        
        $root = FooAPI::getRoot();
        $router = new Router($root);
        $router->getDispatcher()->setContainer($container);
        $router->addProvider(new RouteProvider());

        $this->queueMiddleware(new CatchAll());
        $this->queueMiddleware(new RequestReroot($this->environment->getValue('SCRIPT_NAME')));
        $this->queueMiddleware(new JDispatch($router->getDispatcher()));
    }
}
