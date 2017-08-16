<?php

namespace Enqueue\Tactician\Interop\Tests\Impl;

use Enqueue\Tactician\Interop\Impl\NativePhpSerializer;
use Enqueue\Tactician\Interop\InteropMiddlewareSerializer;
use PHPUnit\Framework\TestCase;

class NativePhpSerializerTest extends TestCase
{
    public function testShouldImplementInteropMiddlewareSerializerInterface()
    {
        $this->assertInstanceOf(InteropMiddlewareSerializer::class, new NativePhpSerializer());
    }

    public function testShouldSerializeObject()
    {
        $serializer = new NativePhpSerializer();

        $string = $serializer->serialize(new NativePhpSerializerTestObject());

        $this->assertInternalType('string', $string);
        $this->assertEquals(serialize(new NativePhpSerializerTestObject()), $string);
    }

    public function testShouldDeserializeStringIntoObject()
    {
        $serializer = new NativePhpSerializer();

        $object = $serializer->deserialize(serialize(new NativePhpSerializerTestObject()));

        $this->assertInstanceOf(NativePhpSerializerTestObject::class, $object);
        $this->assertEquals('value', $object->getProp());
    }
}

class NativePhpSerializerTestObject
{
    private $prop = 'value';

    /**
     * @return string
     */
    public function getProp()
    {
        return $this->prop;
    }
}
