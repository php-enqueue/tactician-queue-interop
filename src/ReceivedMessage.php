<?php
namespace Enqueue\Tactician;

use Interop\Queue\PsrMessage;

/**
 * Indicates that the message is received from a MQ broker.
 */
final class ReceivedMessage
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