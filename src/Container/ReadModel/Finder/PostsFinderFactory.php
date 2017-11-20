<?php

declare(strict_types=1);

namespace Prooph\Demo\Container\ReadModel\Finder;

use Prooph\Demo\ReadModel\Finder\PostsFinder;
use Psr\Container\ContainerInterface;

class PostsFinderFactory
{
    public function __invoke(ContainerInterface $container): PostsFinder
    {
        return new PostsFinder($container->get('pdo.connection'));
    }
}
