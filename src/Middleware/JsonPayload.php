<?php

declare(strict_types=1);

namespace Prooph\Demo\Middleware;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Webimpress\HttpMiddlewareCompatibility\MiddlewareInterface;
use const Webimpress\HttpMiddlewareCompatibility\HANDLER_METHOD;

class JsonPayload implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, DelegateInterface $handler): ResponseInterface
    {
        $contentType = trim($request->getHeaderLine('Content-Type'));

        if (0 === strpos($contentType, 'application/json')) {
            $payload = json_decode((string) $request->getBody(), true);
            switch (json_last_error()) {
                case JSON_ERROR_DEPTH:
                    throw new \RuntimeException('Invalid JSON, maximum stack depth exceeded.', 400);
                case JSON_ERROR_UTF8:
                    throw new \RuntimeException('Malformed UTF-8 characters, possibly incorrectly encoded.', 400);
                case JSON_ERROR_SYNTAX:
                case JSON_ERROR_CTRL_CHAR:
                case JSON_ERROR_STATE_MISMATCH:
                    throw new \RuntimeException('Invalid JSON.', 400);
            }

            $request = $request->withParsedBody(null === $payload ? [] : $payload);
        }

        return $handler->{HANDLER_METHOD}($request);
    }
}
