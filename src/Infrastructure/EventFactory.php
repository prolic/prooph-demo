<?php

declare(strict_types=1);

namespace Prooph\Demo\Infrastructure;

use Prooph\Common\Messaging\DomainMessage;
use Prooph\Common\Messaging\Message;
use Prooph\Common\Messaging\MessageFactory;
use Prooph\Demo\Model\Event\PostWasCreated;
use Ramsey\Uuid\Uuid;

final class EventFactory implements MessageFactory
{
    protected $messageMap = [
        'post-was-created' => PostWasCreated::class,
    ];

    public function createMessageFromArray(string $messageName, array $messageData): Message
    {
        if (isset($this->messageMap[$messageName])) {
            $messageClass = $this->messageMap[$messageName];
        } else {
            $messageClass = $messageName;
        }

        if (! class_exists($messageClass)) {
            throw new \UnexpectedValueException('Given message name is not a valid class: ' . (string)$messageClass);
        }

        if (! is_subclass_of($messageClass, DomainMessage::class)) {
            throw new \UnexpectedValueException(sprintf(
                'Message class %s is not a sub class of %s',
                $messageClass,
                DomainMessage::class
            ));
        }

        if (! isset($messageData['message_name'])) {
            $messageData['message_name'] = $messageName;
        }

        if (! isset($messageData['uuid'])) {
            $messageData['uuid'] = Uuid::uuid4();
        }

        if (! isset($messageData['version'])) {
            $messageData['version'] = 0;
        }

        if (! isset($messageData['created_at'])) {
            $time = (string)microtime(true);
            if (false === strpos($time, '.')) {
                $time .= '.0000';
            }
            $messageData['created_at'] = \DateTimeImmutable::createFromFormat('U.u', $time);
        }

        if (! isset($messageData['metadata'])) {
            $messageData['metadata'] = [];
        }

        return $messageClass::fromArray($messageData);
    }
}
