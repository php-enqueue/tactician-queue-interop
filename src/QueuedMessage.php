<?php
namespace Enqueue\Tactician;

use Interop\Queue\PsrMessage;

/**
 * Indicates that the message has been sent to a MQ broker.
 */
final class QueuedMessage
{
    /**
     * @var PsrMessage
     */
    private $message;

    /**
     * @param PsrMessage $message
     */
    public function __construct(PsrMessage $message)
    {
        $this->message = $message;
    }

    /**
     * @return PsrMessage
     */
    public function getMessage()
    {
        return $this->message;
    }
}