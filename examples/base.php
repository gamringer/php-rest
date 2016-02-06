<?php

ini_set('xdebug.var_display_max_depth', 10);
ini_set('display_errors', true);
error_reporting(E_ALL);

include dirname(__FILE__).'/../vendor/autoload.php';
/*
$container = new League\Container\Container();
$container->share('controllers-author_item', 'gamringer\PHPREST\Example\Controllers\AuthorController');

$environment = gamringer\PHPREST\Environment::fromGlobals();
$root = \gamringer\PHPREST\Example\FooAPI::getRoot();

$router = new \gamringer\PHPREST\JPRouter($root);

$dispatcher = new \gamringer\PHPREST\JPDispatcher($router);
$dispatcher->setContainer($container);
$dispatcher->defineController(
    'GET',
    \gamringer\PHPREST\Example\Models\AuthorModel::class,
    'controllers-author_item::handleGet'
);

$request = $environment->getRequest();
$uri = $request->getUri();
$uri = $uri->withPath('/authors/22');
$request = $request->withUri($uri);
$response = $dispatcher->dispatch($request);
var_dump($response->getBody()->getContents());

exit;
*/
$environment = gamringer\PHPREST\Environment::fromGlobals();
$kernel = new gamringer\PHPREST\Example\Kernel($environment);

$response = $kernel->handle($environment->getRequest());
$kernel->send($response);

$kernel->shutdown();
