<?php

namespace League\Tactician\Interop\Impl;

use League\Tactician\Interop\InteropMiddlewareSerializer;

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
