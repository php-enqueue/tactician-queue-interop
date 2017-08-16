<?php

namespace Enqueue\Tactician\Interop\Tests;

use Interop\Queue\PsrMessage;
use Enqueue\Tactician\Interop\InteropMiddleware;
use Enqueue\Tactician\Interop\InteropMiddlewareSerializer;
use Enqueue\Tactician\Interop\InteropMiddlewareTransport;
use League\Tactician\Middleware;
use PHPUnit\Framework\TestCase;

class InteropMiddlewareTest extends TestCase
{
    public function testShouldImplementMiddlewareInterface()
    {
        $this->assertInstanceOf(Middleware::class, new InteropMiddleware(
            $this->createMiddlewareTransportMock(),
            $this->createMiddlewareSerializerMock()
        ));
    }

    public function testShouldDeserializePsrMessageAndPassToNext()
    {
        $deserializedCommand = null;

        $next = function($str) use (&$deserializedCommand) {
            $deserializedCommand = $str;
        };

        $message = $this->createPsrMessage();
        $message
            ->expects($this->once())
            ->method('getBody')
            ->willReturn('the body')
        ;

        $serializer = $this->createMiddlewareSerializerMock();
        $serializer
            ->expects($this->once())
            ->method('deserialize')
            ->with($this->identicalTo('the body'))
            ->willReturn('the deserialized body')
        ;

        $middleware = new InteropMiddleware($this->createMiddlewareTransportMock(), $serializer);
        $middleware->execute($message, $next);

        $this->assertSame('the deserialized body', $deserializedCommand);
    }

    public function testShouldSerializeCommandAndPassToTransport()
    {
        $transport = $this->createMiddlewareTransportMock();
        $transport
            ->expects($this->once())
            ->method('send')
            ->with('serialized command')
        ;

        $serializer = $this->createMiddlewareSerializerMock();
        $serializer
            ->expects($this->once())
            ->method('serialize')
            ->with($this->identicalTo('command'))
            ->willReturn('serialized command')
        ;

        $middleware = new InteropMiddleware($transport, $serializer);
        $middleware->execute('command', function(){});
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|PsrMessage
     */
    private function createPsrMessage()
    {
        return $this->createMock(PsrMessage::class);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|InteropMiddlewareSerializer
     */
    private function createMiddlewareSerializerMock()
    {
        return $this->createMock(InteropMiddlewareSerializer::class);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|InteropMiddlewareTransport
     */
    private function createMiddlewareTransportMock()
    {
        return $this->createMock(InteropMiddlewareTransport::class);
    }
}
