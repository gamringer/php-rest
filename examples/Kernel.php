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
        
        $router = new Router();
        $root = FooAPI::getRoot();
        $router->setRoot($root);

        $dispatcher = new Dispatcher($router);
        $dispatcher->setContainer($container);
        $dispatcher->defineController(
            'GET',
            \gamringer\PHPREST\Example\Models\AuthorModel::class,
            'controllers-author_item::handleGet'
        );

        $this->queueMiddleware(new CatchAll());
        $this->queueMiddleware(new RequestReroot($this->environment->getValue('SCRIPT_NAME')));
        $this->queueMiddleware(new JDispatch($dispatcher));
    }
}
