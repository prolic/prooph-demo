<?php

declare(strict_types=1);

namespace Prooph\Demo\Model;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class PostId
{
    /**
     * @var UuidInterface
     */
    private $uuid;

    public static function fromUuid(UuidInterface $uuid): PostId
    {
        return new self($uuid);
    }

    public static function fromString(string $uuid): PostId
    {
        if (! Uuid::isValid($uuid)) {
            throw new \InvalidArgumentException('Invalid uuid given');
        }

        return new self(Uuid::fromString($uuid));
    }

    private function __construct(UuidInterface $uuid)
    {
        $this->uuid = $uuid;
    }

    public function __toString(): string
    {
        return $this->uuid->toString();
    }
}
