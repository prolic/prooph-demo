<?php

declare(strict_types=1);

namespace Prooph\Demo\Response;

use Prooph\Psr7Middleware\Response\ResponseStrategy;
use Psr\Http\Message\ResponseInterface;
use React\Promise\PromiseInterface;
use Zend\Diactoros\Response\JsonResponse as ZendJsonResponse;

final class JsonResponse implements ResponseStrategy
{
    public function fromPromise(PromiseInterface $promise): ResponseInterface
    {
        $json = null;
        $promise->then(function ($data) use (&$json) {
            $json = $data;
        });

        return new ZendJsonResponse($json);
    }

    public function withStatus(int $statusCode): ResponseInterface
    {
        return new ZendJsonResponse([], $statusCode);
    }
}
