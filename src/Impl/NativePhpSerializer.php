<?php

namespace Enqueue\Tactician\Interop\Impl;

use Enqueue\Tactician\Interop\InteropMiddlewareSerializer;

class NativePhpSerializer implements InteropMiddlewareSerializer
{
    /**
     * {@inheritdoc}
     */
    public function serialize($object)
    {
        return serialize($object);
    }

    /**
     * {@inheritdoc}
     */
    public function deserialize($string)
    {
        return unserialize($string);
    }
}
