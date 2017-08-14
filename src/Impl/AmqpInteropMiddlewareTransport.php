<?php

namespace League\Tactician\Interop\Impl;

use Interop\Amqp\AmqpContext;
use Interop\Amqp\AmqpQueue;

class AmqpInteropMiddlewareTransport extends InteropQueueMiddlewareTransport
{
    /**
     * @var bool
     */
    private $isDeclared = false;

    /**
     * @param AmqpContext $context
     * @param string      $queueName
     */
    public function __construct(AmqpContext $context, $queueName)
    {
        parent::__construct($context, $queueName);
    }

    /**
     * {@inheritdoc}
     */
    protected function createQueue()
    {
        /** @var AmqpQueue $queue */
        $queue = parent::createQueue();
        $queue->addFlag(AmqpQueue::FLAG_DURABLE);

        if (false == $this->isDeclared) {
            $this->getContext()->declareQueue($queue);
            $this->isDeclared = true;
        }

        return $queue;
    }
}
