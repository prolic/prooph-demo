<?php

declare(strict_types=1);

namespace Prooph\Demo\Model;

use Prooph\EventStore\Util\Assertion;

final class Content
{
    /**
     * @var string
     */
    private $content;

    public static function fromString(string $content)
    {
        Assertion::notEmpty($content);

        return new self($content);
    }

    private function __construct(string $content)
    {
        $this->content = $content;
    }

    public function __toString(): string
    {
        return $this->content;
    }
}