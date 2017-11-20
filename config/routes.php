<?php

declare(strict_types=1);

namespace Prooph\Demo;

use Prooph\Demo\App\Action;
use Prooph\Demo\Middleware\JsonPayload;
use Prooph\Psr7Middleware\CommandMiddleware;

/** @var \Zend\Expressive\Application $app */
$app->get('/', Action\PostList::class, 'page::post-list');
$app->get('/create-post', Action\CreatePost::class, 'page::create-post');
$app->post('/api/create-post', [
    JsonPayload::class,
    CommandMiddleware::class,
], 'command::create-post')
    ->setOptions([
        'values' => [
            'prooph_command_name' => 'create-post',
        ],
    ]);
