<?php

namespace Enqueue\Tactician\Interop\Tests;

use Interop\Queue\PsrContext;
use Interop\Queue\PsrMessage;
use Interop\Queue\PsrProcessor;
use League\Tactician\CommandBus;
use Enqueue\Tactician\Interop\InteropMiddlewareProcessor;
use PHPUnit\Framework\TestCase;

class InteropMiddlewareProcessorTest extends TestCase
{
    public function testShouldImplementPsrProcessorInterface()
    {
        $this->assertInstanceOf(PsrProcessor::class, new InteropMiddlewareProcessor($this->createCommandBusMock()));
    }

    public function testShouldPassPsrMessageToCommandBus()
    {
        $message = $this->createPsrMessageMock();

        $bus = $this->createCommandBusMock();
        $bus
            ->expects($this->once())
            ->method('handle')
            ->with($this->identicalTo($message))
        ;

        $processor = new InteropMiddlewareProcessor($bus);
        $result = $processor->process($message, $this->createMock(PsrContext::class));

        $this->assertSame(PsrProcessor::ACK, $result);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|PsrMessage
     */
    private function createPsrMessageMock()
    {
        return $this->createMock(PsrMessage::class);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|CommandBus
     */
    private function createCommandBusMock()
    {
        return $this->createMock(CommandBus::class);
    }
}
