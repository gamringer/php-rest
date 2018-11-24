<?php

declare(strict_types=1);

namespace gamringer\PHPREST\RequestHandling;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use \gamringer\PHPREST\Resources\Resource;

interface RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request, Resource $resource): ResponseInterface;
}
