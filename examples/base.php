<?php

declare(strict_types=1);

ini_set('xdebug.var_display_max_depth', '10');
ini_set('display_errors', '1');
error_reporting(E_ALL);

include dirname(__FILE__).'/../vendor/autoload.php';

$environment = new gamringer\PHPREST\HTTPEnvironment([
	'SERVER_PROTOCOL' => 'HTTP/1.1',
	'REQUEST_METHOD' => 'GET',
	'REQUEST_URI' => '/',
	'HTTP_HOST' => 'example.local',
], fopen('php://output', 'w'), fopen('php://input', 'r+'), [
    'get' => [],
    'post' => [],
    'files' => [],
    'cookies' => [],
]);
$kernel = new gamringer\PHPREST\Example\Kernel($environment);

$response = $kernel->handle($environment->getRequest());
$kernel->send($response);

$kernel->shutdown();
