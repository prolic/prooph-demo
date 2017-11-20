<?php

declare(strict_types=1);

namespace Prooph\Demo\Container\Model;

use Prooph\Demo\Model\Handler\CreatePostHandler;
use Prooph\Demo\Model\PostCollection;
use Psr\Container\ContainerInterface;

class CreatePostHandlerFactory
{
    public function __invoke(ContainerInterface $container): CreatePostHandler
    {
        return new CreatePostHandler($container->get(PostCollection::class));
    }
}
