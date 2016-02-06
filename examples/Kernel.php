<?php

namespace gamringer\PHPREST\Example;

use \gamringer\PHPREST\Kernel as BaseKernel;
use \gamringer\PHPREST\Middlewares\RequestReroot;
use \gamringer\PHPREST\Middlewares\JDispatch;
use \gamringer\PHPREST\JPRouter;
use \gamringer\PHPREST\JPDispatcher;
use \League\Container\Container;

class Kernel extends BaseKernel
{
    public function init()
    {
        $root = FooAPI::getRoot();

        $router = new JPRouter();
        $router->setRoot($root);

        $container = new Container();
        $container->share('controllers-author_item', 'gamringer\PHPREST\Example\Controllers\AuthorController');

        $dispatcher = new JPDispatcher($router);
        $dispatcher->setContainer($container);
        $dispatcher->defineController(
            'GET',
            \gamringer\PHPREST\Example\Models\AuthorModel::class,
            'controllers-author_item::handleGet'
        );

        $this->queueMiddleware(new RequestReroot($this->environment->getValue('SCRIPT_NAME')));
        $this->queueMiddleware(new JDispatch($dispatcher));
    }
}
