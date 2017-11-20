<?php

declare(strict_types=1);

namespace Prooph\Demo\Model;

use Prooph\EventStore\Util\Assertion;

final class Title
{
    /**
     * @var string
     */
    private $title;

    public static function fromString(string $title)
    {
        Assertion::notEmpty($title);

        return new self($title);
    }

    private function __construct(string $title)
    {
        $this->title = $title;
    }

    public function __toString(): string
    {
        return $this->title;
    }
}