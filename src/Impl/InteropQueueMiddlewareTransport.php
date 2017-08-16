<?php

namespace Enqueue\Tactician\Interop\Impl;

use Interop\Queue\PsrContext;
use Interop\Queue\PsrProducer;
use Enqueue\Tactician\Interop\InteropMiddlewareTransport;

class InteropQueueMiddlewareTransport implements InteropMiddlewareTransport
{
    /**
     * @var PsrContext
     */
    private $context;

    /**
     * @var string
     */
    private $queueName;

    /**
     * @param PsrContext $context
     * @param string     $queueName
     */
    public function __construct(PsrContext $context, $queueName)
    {
        $this->context = $context;
        $this->queueName = $queueName;
    }

    /**
     * {@inheritdoc}
     */
    public function send($commandAsString)
    {
        $this->createProducer()->send($this->createQueue(), $this->createMessage($commandAsString));
    }

    protected function createQueue()
    {
        return $this->getContext()->createQueue($this->queueName);
    }

    /**
     * @param string $body
     *
     * @return \Interop\Queue\PsrMessage
     */
    protected function createMessage($body)
    {
        return $this->getContext()->createMessage($body);
    }

    /**
     * @return PsrProducer
     */
    protected function createProducer()
    {
        return $this->getContext()->createProducer();
    }

    /**
     * @return PsrContext
     */
    protected function getContext()
    {
        return $this->context;
    }
}
