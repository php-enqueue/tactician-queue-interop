<?php

namespace Enqueue\Tactician;

use Interop\Queue\PsrContext;
use League\Tactician\Middleware;

final class NormalizerMiddleware implements Middleware
{
    /**
     * @var PsrContext
     */
    private $context;

    /**
     * @var Serializer
     */
    private $serializer;

    /**
     * @param Serializer $serializer
     * @param PsrContext $context
     */
    public function __construct(Serializer $serializer, PsrContext $context)
    {
        $this->serializer = $serializer;
        $this->context = $context;
    }

    /**
     * {@inheritdoc}
     */
    public function execute($command, callable $next)
    {
        if ($command instanceof QueueMessage) {
            return $next($this->context->createMessage($this->serializer->serialize($command->getMessage())));
        }

        if ($command instanceof ReceivedMessage) {
            $serializedCommand = $command->getMessage()->getBody();

            return $next($this->serializer->deserialize($serializedCommand));
        }

        return $next($command);
    }
}
