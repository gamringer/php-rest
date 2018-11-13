<?php

declare(strict_types=1);

ini_set('xdebug.var_display_max_depth', '10');
ini_set('display_errors', '1');
error_reporting(E_ALL);

include dirname(__FILE__).'/../vendor/autoload.php';

$httpEnvironment = new gamringer\PHPREST\HTTPEnvironment([
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

$cliEnvironment = new gamringer\PHPREST\CLIEnvironment([], fopen('php://output', 'w'), fopen('php://input', 'r+'));

$kernel = new gamringer\PHPREST\Example\Kernel($httpEnvironment);

$response = $kernel->handle($httpEnvironment->getRequest());
$cliEnvironment->send($response);

$kernel->shutdown();
?>

