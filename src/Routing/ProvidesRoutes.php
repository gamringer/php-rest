<?php

namespace gamringer\PHPREST\Routing;

use \gamringer\PHPREST\Router;

interface ProvidesRoutes
{
    public function feed(Router $router);
}