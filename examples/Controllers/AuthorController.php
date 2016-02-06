<?php

namespace gamringer\PHPREST\Example\Controllers;

use \GuzzleHttp\Psr7;

class AuthorController
{
    public static function handleGet($request, $resource)
    {
        return new Psr7\Response(200, [], 'allo');
    }
}
