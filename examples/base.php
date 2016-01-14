<?php

ini_set('xdebug.var_display_max_depth', 10);
ini_set('display_errors', true);
error_reporting(E_ALL);

include dirname(__FILE__).'/../vendor/autoload.php';

use \gamringer\PHPREST\RESTKernel;
use \gamringer\PHPREST\Environment;
use \gamringer\PHPREST\Router;
use \gamringer\PHPREST\Example\FooAPI;
use \League\Container\Container;

$root = FooAPI::getRoot();

$router = new \gamringer\PHPREST\JPRouter();
$router->setRoot($root);

$dispatcher = new \gamringer\PHPREST\JPDispatcher($router);
$dispatcher->setPathLocation('/php-rest.php');

$environment = Environment::fromGlobals();
$kernel = new RESTKernel($environment);
$kernel->setDispatcher($dispatcher);

$response = $kernel->handle($environment->getRequest());
$kernel->send($response);

$kernel->shutdown();
