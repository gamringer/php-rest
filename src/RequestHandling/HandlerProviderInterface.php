<?php
declare(strict_types=1);

namespace gamringer\PHPREST\RequestHandling;

interface HandlerProviderInterface
{
    public function provide(string $handlerName): RequestHandlerInterface;
}
