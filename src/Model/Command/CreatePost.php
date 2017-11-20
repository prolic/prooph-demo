<?php

declare(strict_types=1);

namespace Prooph\Demo\Model\Command;

use Prooph\Common\Messaging\Command;
use Prooph\Common\Messaging\PayloadTrait;
use Prooph\Demo\Model\Content;
use Prooph\Demo\Model\PostId;
use Prooph\Demo\Model\Title;

final class CreatePost extends Command
{
    /**
     * @var string
     */
    protected $messageName = 'create-post';

    use PayloadTrait;

    public function postId(): PostId
    {
        return PostId::fromString($this->payload()['postId']);
    }

    public function title(): Title
    {
        return Title::fromString($this->payload()['title']);
    }

    public function content(): Content
    {
        return Content::fromString($this->payload()['content']);
    }
}
