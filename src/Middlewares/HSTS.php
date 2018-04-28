<?php

namespace gamringer\PHPREST\Middlewares;

use \Psr\Http\Message\RequestInterface;
use \Telegraph\MiddlewareInterface;
use \GuzzleHttp\Psr7;

class HSTS implements MiddlewareInterface
{
    protected $permissive;
    protected $duration;
    protected $includeSubdomains;
    protected $preload;

    public function __construct($permissive = false, $duration = 31536000, $includeSubdomains = false, $preload = false)
    {
        $this->permissive = $permissive;
        $this->duration = $duration;
        $this->includeSubdomains = $includeSubdomains;
        $this->preload = $preload;
    }

    public function __invoke (RequestInterface $request, callable $next = null)
    {
        if ($request->getUri()->getScheme() == 'https') {
            $response = $next($request);

            $hstsValue = 'max-age='.$this->duration;
            if ($this->includeSubdomains) {
                $hstsValue .= '; includeSubDomains';
            }
            if ($this->preload) {
                $hstsValue .= '; preload';
            }

            return $response->withHeader('Strict-Transport-Security', $hstsValue);
        }

        if ($this->permissive) {
            return new Psr7\Response(301, ['Location' => $request->getUri()->withScheme('https')]);
        }

        return new Psr7\Response(403, [], 'This page can only be accessed over HTTPS');
    }
}
