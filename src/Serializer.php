<?php

namespace Enqueue\Tactician;

interface Serializer
{
    /**
     * @param mixed $mixed
     *
     * @return string
     */
    public function serialize($mixed);

    /**
     * @param string $string
     *
     * @return mixed
     */
    public function deserialize($string);
}
