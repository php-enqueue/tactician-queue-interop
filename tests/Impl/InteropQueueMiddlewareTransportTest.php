<?php

namespace Enqueue\Tactician\Interop\Tests\Impl;

use Interop\Queue\PsrContext;
use Interop\Queue\PsrMessage;
use Interop\Queue\PsrProducer;
use Interop\Queue\PsrQueue;
use Enqueue\Tactician\Interop\Impl\InteropQueueMiddlewareTransport;
use Enqueue\Tactician\Interop\InteropMiddlewareTransport;
use PHPUnit\Framework\TestCase;

class InteropQueueMiddlewareTransportTest extends TestCase
{
    public function testShouldImplementInteropMiddlewareTransportInterface()
    {
        $this->assertInstanceOf(InteropMiddlewareTransport::class, new InteropQueueMiddlewareTransport($this->createPsrContextMock(), ''));
    }

    public function testShouldSendCommand()
    {
        $queue = $this->createPsrQueueMock();
        $message = $this->createPsrMessageMock();

        $producer = $this->createPsrProducerMock();
        $producer
            ->expects($this->once())
            ->method('send')
            ->with($this->identicalTo($queue), $this->identicalTo($message))
        ;

        $context = $this->createPsrContextMock();
        $context
            ->expects($this->once())
            ->method('createMessage')
            ->willReturn($message)
        ;
        $context
            ->expects($this->once())
            ->method('createQueue')
            ->willReturn($queue)
        ;
        $context
            ->expects($this->once())
            ->method('createProducer')
            ->willReturn($producer)
        ;

        $transport = new InteropQueueMiddlewareTransport($context, 'the-queue');
        $transport->send('command');
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|PsrContext
     */
    private function createPsrContextMock()
    {
        return $this->createMock(PsrContext::class);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|PsrProducer
     */
    private function createPsrProducerMock()
    {
        return $this->createMock(PsrProducer::class);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|PsrQueue
     */
    private function createPsrQueueMock()
    {
        return $this->createMock(PsrQueue::class);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|PsrMessage
     */
    private function createPsrMessageMock()
    {
        return $this->createMock(PsrMessage::class);
    }
}
