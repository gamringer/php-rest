<?php

namespace gamringer\PHPREST\Example;

use \gamringer\PHPREST\Routing\ProvidesRoutes;
use \gamringer\PHPREST\Router;

class RouteProvider implements ProvidesRoutes
{
    public function feed(Router $router)
    {
        $router->addRoute(
            'GET',
            \gamringer\PHPREST\Example\Models\AuthorModel::class,
            'controller-author_item::handleGet'
        );
    }
}
