<?php

namespace Enqueue\Tactician\Interop;


interface InteropMiddlewareSerializer
{
    /**
     * @param object $object
     *
     * @return string
     */
    public function serialize($object);

    /**
     * @param string $string
     *
     * @return object
     */
    public function deserialize($string);
}
