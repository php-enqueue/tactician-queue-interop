<?php

namespace League\Tactician\Interop\Tests\Impl;

use Interop\Amqp\AmqpContext;
use Interop\Amqp\Impl\AmqpQueue;
use League\Tactician\Interop\Impl\AmqpInteropMiddlewareTransport;
use League\Tactician\Interop\InteropMiddlewareTransport;
use PHPUnit\Framework\TestCase;

class AmqpInteropMiddlewareTransportTest extends TestCase
{
    public function testShouldImplementInteropMiddlewareTransportInterface()
    {
        $this->assertInstanceOf(InteropMiddlewareTransport::class, new AmqpInteropMiddlewareTransport($this->createAmqpContextMock(), ''));
    }

    public function testShouldCreateAndDeclareQueue()
    {
        $queue = new AmqpQueue('the queue');

        $context = $this->createAmqpContextMock();
        $context
            ->expects($this->once())
            ->method('createQueue')
            ->with('the queue')
            ->willReturn($queue)
        ;
        $context
            ->expects($this->once())
            ->method('declareQueue')
            ->with($this->identicalTo($queue))
        ;

        $transport = new AmqpInteropMiddlewareTransport($context, 'the queue');

        $rm = new \ReflectionMethod(AmqpInteropMiddlewareTransport::class, 'createQueue');
        $rm->setAccessible(true);
        $queue = $rm->invoke($transport);

        $this->assertSame('the queue', $queue->getQueueName());
        $this->assertSame(AmqpQueue::FLAG_DURABLE, $queue->getFlags());
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|AmqpContext
     */
    private function createAmqpContextMock()
    {
        return $this->createMock(AmqpContext::class);
    }
}
