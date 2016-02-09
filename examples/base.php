<?php

ini_set('xdebug.var_display_max_depth', 10);
ini_set('display_errors', true);
error_reporting(E_ALL);

include dirname(__FILE__).'/../vendor/autoload.php';

$environment = gamringer\PHPREST\Environment::fromGlobals();
$kernel = new gamringer\PHPREST\Example\Kernel($environment);

$response = $kernel->handle($environment->getRequest());
$kernel->send($response);

$kernel->shutdown();
