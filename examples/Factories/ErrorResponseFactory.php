<?php


namespace gamringer\PHPREST\Example\Factories;

use \GuzzleHttp\Psr7;
use gamringer\PHPREST\Resources\Resource;

class ErrorResponseFactory
{
    public function produceResourceNotFound()
    {
        $headers = [
            'Content-Type' => 'application/json',
        ];

        return new Psr7\Response(404, $headers, json_encode([
            'message' => 'Resource not found',
            'code' => 1,
        ]));
    }

    public function produceMethodNotSupported(Resource $resource)
    {
        $headers = [
            'Allow' => $resource->getSupportedMethods(),
            'Content-Type' => 'application/json',
        ];

        return new Psr7\Response(405, $headers, json_encode([
            'message' => 'The requested method is not allowed on this resource',
            'code' => 2,
        ]));
    }
}
