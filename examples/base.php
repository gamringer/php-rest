<?php

ini_set('xdebug.var_display_max_depth', 10);
ini_set('display_errors', true);
error_reporting(E_ALL);

include dirname(__FILE__).'/../vendor/autoload.php';

use \gamringer\PHPREST\Kernel;
use \gamringer\PHPREST\Environment;
use \gamringer\PHPREST\Router;
use \gamringer\PHPREST\Example\FooAPI;
use \League\Container\Container;

$root = FooAPI::getRoot();
$router = new \gamringer\PHPREST\JPRouter();
$router->setRoot($root);

$environment = Environment::fromGlobals();
$kernel = new Kernel($environment);
$kernel->setRouter($router);
$kernel->setPathLocation('/php-rest.php');

$request = $environment->getRequest();
$response = $kernel->handle($request);
$kernel->send($response);

$kernel->shutdown();
