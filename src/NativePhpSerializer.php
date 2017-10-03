<?php

namespace Enqueue\Tactician;

class NativePhpSerializer implements Serializer
{
    /**
     * {@inheritdoc}
     */
    public function serialize($mixed)
    {
        return serialize($mixed);
    }

    /**
     * {@inheritdoc}
     */
    public function deserialize($string)
    {
        return unserialize($string);
    }
}
