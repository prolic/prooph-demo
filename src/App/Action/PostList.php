<?php

declare(strict_types=1);

namespace Prooph\Demo\App\Action;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Prooph\Demo\ReadModel\Query\FetchPosts;
use Prooph\ServiceBus\QueryBus;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Template\TemplateRendererInterface;

class PostList implements MiddlewareInterface
{
    /**
     * @var QueryBus
     */
    private $queryBus;

    /**
     * @var TemplateRendererInterface
     */
    private $templates;

    public function __construct(QueryBus $queryBus, TemplateRendererInterface $templates)
    {
        $this->queryBus = $queryBus;
        $this->templates = $templates;
    }


    public function process(ServerRequestInterface $request, DelegateInterface $delegate): ResponseInterface
    {
        $results = null;

        $promise = $this->queryBus->dispatch(new FetchPosts([]));
        $promise->then(function ($result) use (& $results): void {
            $results = $result;
        });

        return new HtmlResponse(
            $this->templates->render('page::post-list', ['posts' => $results])
        );
    }
}
