<?php
namespace Enqueue\Tactician;

/**
 * Indicates that the message must be queued to a MQ broker.
 */
final class QueueMessage
{
    /**
     * @var mixed
     */
    private $message;

    /**
     * @param mixed $message
     */
    public function __construct($message)
    {
        $this->message = $message;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }
}