<?php

declare(strict_types=1);

namespace Prooph\Demo\Container\App\Action;

use Prooph\Demo\App\Action\PostList;
use Prooph\ServiceBus\QueryBus;
use Psr\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

class PostListFactory
{
    public function __invoke(ContainerInterface $container): PostList
    {
        return new PostList(
            $container->get(QueryBus::class),
            $container->get(TemplateRendererInterface::class)
        );
    }
}
