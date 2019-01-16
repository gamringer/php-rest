<?php

declare(strict_types=1);

namespace gamringer\PHPREST;

use GuzzleHttp\Psr7;
use Psr\Http\Message\ResponseInterface;

class HTTPEnvironment extends Environment
{
    protected $request;
    protected $parsed;

    public function __construct($environment, $output, $input, $parsed = [])
    {
        $this->stdIn = Psr7\stream_for($input);
        $this->stdOut = Psr7\stream_for($output);
        $this->environment = $environment;
        $this->parsed = $parsed;
    }

    public function getRequest(): Psr7\ServerRequest
    {
        if (!isset($this->request)) {
            list($protocolName, $protocolVersion) = explode('/', $this->environment['SERVER_PROTOCOL']);
            $scheme = 'http';
            if (array_key_exists('HTTPS', $this->environment) && $this->environment['HTTPS'] == 'on') {
                $scheme = 'https';
            }

            $headers = $this->getallheaders();

            $host = $this->environment['HTTP_HOST'] ?? $this->environment['SERVER_NAME'];

            $this->request = new Psr7\ServerRequest(
                $this->environment['REQUEST_METHOD'],
                $scheme.'://'.$host.$this->environment['REQUEST_URI'],
                $headers,
                $this->stdIn,
                $protocolVersion
            );

            if (array_key_exists('get', $this->parsed)) {
                $this->request = $this->request->withQueryParams($this->parsed['get']);
            }
            if (array_key_exists('cookies', $this->parsed)) {
                $this->request = $this->request->withCookieParams($this->parsed['cookies']);
            }
            if (!array_key_exists('Content-Type', $headers)) {
            } elseif ($headers['Content-Type'] == 'application/json') {
                $this->request = $this->request->withParsedBody(json_decode(Psr7\copy_to_string($this->stdIn)));
            } elseif ($headers['Content-Type'] == 'application/x-www-form-urlencoded') {
                $this->request = $this->request->withParsedBody($this->parsed['post']);
            } elseif ($headers['Content-Type'] == 'multipart/form-data') {
                $this->request = $this->request
                            ->withParsedBody($this->parsed['post'])
                            ->withUploadedFiles(Psr7\ServerRequest::normalizeFiles($this->parsed['files']))
                ;
            }
        }

        return $this->request;
    }

    private function getallheaders(): array
    {
        $headers = array();

        $copy_server = array(
            'CONTENT_TYPE'   => 'Content-Type',
            'CONTENT_LENGTH' => 'Content-Length',
            'CONTENT_MD5'    => 'Content-Md5',
        );

        foreach ($this->environment as $key => $value) {
            if (substr($key, 0, 5) === 'HTTP_') {
                $key = substr($key, 5);
                if (!isset($copy_server[$key]) || !isset($this->environment[$key])) {
                    $key = str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', $key))));
                    $headers[$key] = $value;
                }
            } elseif (isset($copy_server[$key])) {
                $headers[$copy_server[$key]] = $value;
            }
        }

        if (!isset($headers['Authorization'])) {
            $authValue = $this->composeAuthorizationHeaderValue();
            if ($authValue !== null) {
                $headers['Authorization'] = $authValue;
            }
        }

        return $headers;
    }

    public function getClientIP(): string
    {
        return $this->environment['REMOTE_ADDR'];
    }

    public function getClientCertificate(): ?string
    {
        if (array_key_exists('SSL_CLIENT_CERT', $this->environment)
         && !empty($this->environment['SSL_CLIENT_CERT'])) {
            return $this->environment['SSL_CLIENT_CERT'];
        }

        return null;
    }

    private function composeAuthorizationHeaderValue(): ?string
    {
        if (isset($this->environment['REDIRECT_HTTP_AUTHORIZATION'])) {
            return $this->environment['REDIRECT_HTTP_AUTHORIZATION'];
        } elseif (isset($this->environment['PHP_AUTH_USER'])) {
            $basic_pass = isset($this->environment['PHP_AUTH_PW']) ? $this->environment['PHP_AUTH_PW'] : '';
            return 'Basic ' . base64_encode($this->environment['PHP_AUTH_USER'] . ':' . $basic_pass);
        } elseif (isset($this->environment['PHP_AUTH_DIGEST'])) {
            return $this->environment['PHP_AUTH_DIGEST'];
        }

        return null;
    }

    public function send(ResponseInterface $response): void
    {
        http_response_code($response->getStatusCode());

        foreach ($response->getHeaders() as $header => $values) {
            foreach ($values as $value) {
                header($header . ': ' . $value, false);
            }
        }

        $size = $response->getBody()->getSize();
        if ($size > 0) {
            header('Content-Length: ' . $size);
        }
        Psr7\copy_to_stream($response->getBody(), $this->getStdOut());
    }
}
