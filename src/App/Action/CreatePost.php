<?php

declare(strict_types=1);

namespace Prooph\Demo\App\Action;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Template\TemplateRendererInterface;

class CreatePost implements MiddlewareInterface
{
    /**
     * @var TemplateRendererInterface
     */
    private $templates;

    public function __construct(TemplateRendererInterface $templates)
    {
        $this->templates = $templates;
    }


    public function process(ServerRequestInterface $request, DelegateInterface $delegate): ResponseInterface
    {
        return new HtmlResponse(
            $this->templates->render('page::create-post')
        );
    }
}
