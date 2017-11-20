<?php

declare(strict_types=1);

namespace Prooph\Demo\Container\App\Action;

use Prooph\Demo\App\Action\CreatePost;
use Psr\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

class CreatePostFactory
{
    public function __invoke(ContainerInterface $container): CreatePost
    {
        return new CreatePost($container->get(TemplateRendererInterface::class));
    }
}
