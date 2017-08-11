<?php

namespace League\Tactician\Interop;


interface InteropMiddlewareTransport
{
    /**
     * @param string $commandAsString
     */
    public function send($commandAsString);
}
