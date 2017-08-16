<?php

namespace Enqueue\Tactician\Interop;

use Interop\Queue\PsrContext;
use Interop\Queue\PsrMessage;
use Interop\Queue\PsrProcessor;
use League\Tactician\CommandBus;

class InteropMiddlewareProcessor implements PsrProcessor
{
    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * @param CommandBus $commandBus
     */
    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * {@inheritdoc}
     */
    public function process(PsrMessage $message, PsrContext $context)
    {
        $this->commandBus->handle($message);

        return self::ACK;
    }
}
