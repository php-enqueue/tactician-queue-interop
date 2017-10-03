<?php

namespace Enqueue\Tactician;

use Interop\Amqp\AmqpContext;
use Interop\Amqp\AmqpQueue;
use Interop\Queue\PsrContext;
use Interop\Queue\PsrMessage;
use Interop\Queue\PsrProducer;
use Interop\Queue\PsrQueue;
use League\Tactician\Middleware;

final class QueueMiddleware implements Middleware
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
     * @var bool
     */
    private $isQueueDeclared;

    /**
     * @param PsrContext $context
     * @param string $queueName
     * @param bool $isQueueDeclared
     */
    public function __construct(PsrContext $context, $queueName, $isQueueDeclared = false)
    {
        $this->context = $context;
        $this->queueName = $queueName;
        $this->isQueueDeclared = $isQueueDeclared;
    }

    /**
     * {@inheritdoc}
     */
    public function execute($command, callable $next)
    {
        if ($command instanceof PsrMessage) {
            $this->context->createProducer()->send($this->createQueue(), $command);

            return $next(new QueuedMessage($command));
        }

        return $next($command);
    }

    /**
     * @return PsrQueue
     */
    protected function createQueue()
    {
        $queue = $this->context->createQueue($this->queueName);

        if ($queue instanceof AmqpQueue) {
            /** @var AmqpContext $context */
            $context = $this->context;

            $queue->addFlag(AmqpQueue::FLAG_DURABLE);

            if (false == $this->isQueueDeclared) {
                $context->declareQueue($queue);

                $this->isQueueDeclared = true;
            }
        }

        return $queue;
    }

    /**
     * @return PsrProducer
     */
    protected function createProducer()
    {
        return $this->context->createProducer();
    }
}
