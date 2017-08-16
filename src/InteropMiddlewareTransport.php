<?php

namespace Enqueue\Tactician\Interop;


interface InteropMiddlewareTransport
{
    /**
     * @param string $commandAsString
     */
    public function send($commandAsString);
}
