<?php

declare(strict_types=1);

namespace gamringer\PHPREST\Routing;

use Psr\Http\Message\ServerRequestInterface;
use gamringer\PHPREST\Resources\Resource;

interface ResourceRouterInterface
{
    public function route(ServerRequestInterface $request): Resource;
}
