<?php

namespace gamringer\PHPREST\Middlewares;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Relay\MiddlewareInterface;

class JDispatch implements MiddlewareInterface
{
    protected $pins;
    protected $maxAge;
    protected $includeSubdomains;
    protected $reportURI;
    protected $reportOnly;

    public function __construct($pins, $maxAge, $includeSubdomains = false, $reportURI = null, $reportOnly = false)
    {
        if (!is_array($pins)) {
            $pins = [$pins];
        }
        $this->pins = $pins;
        $this->maxAge = $maxAge;
        $this->includeSubdomains = $includeSubdomains;
        $this->reportURI = $reportURI;
        $this->reportOnly = $reportOnly;
    }

    public function __invoke (RequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        $response = $next($request, $response);

        $headerValue = '';
        foreach ($this->pins as $pin) {
            $headerValue .= 'pin-sha256="'.$pin.'";';
        }
        $headerValue = 'max-age='.$this->maxAge;

        if ($this->includeSubdomains) {
            $headerValue .= '; includeSubDomains';
        }

        if ($this->reportURI != null) {
            $headerValue .= '; report-uri="'.$this->reportURI.'"';
        }

        $headerName = 'Public-Key-Pins';
        if ($this->reportOnly) {
            $headerName = 'Public-Key-Pins-Report-Only';
        }

        return $response->withHeader($headerName, $headerValue);
    }
}