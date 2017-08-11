<?php

namespace League\Tactician\Interop;

use Interop\Queue\PsrContext;
use Interop\Queue\PsrMessage;
use League\Tactician\Middleware;

class InteropMiddleware implements Middleware
{
    /**
     * @var PsrContext
     */
    private $transport;

    /**
     * @var InteropMiddlewareSerializer
     */
    private $serializer;

    /**
     * @param InteropMiddlewareTransport  $transport
     * @param InteropMiddlewareSerializer $serializer
     */
    public function __construct(InteropMiddlewareTransport $transport, InteropMiddlewareSerializer $serializer)
    {
        $this->transport = $transport;
        $this->serializer = $serializer;
    }

    /**
     * {@inheritdoc}
     */
    public function execute($command, callable $next)
    {
        if ($command instanceof PsrMessage) {
            return $next($this->serializer->deserialize($command->getBody()));
        }

        $this->transport->send($this->serializer->serialize($command));
    }
}
