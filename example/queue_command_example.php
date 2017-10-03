<?php

use Enqueue\Fs\FsConnectionFactory;
use Enqueue\Tactician\NativePhpSerializer;
use Enqueue\Tactician\NormalizerMiddleware;
use Enqueue\Tactician\QueuedMessage;
use Enqueue\Tactician\QueueMessage;
use Enqueue\Tactician\QueueMiddleware;
use Enqueue\Tactician\TacticianProcessor;
use League\Tactician\CommandBus;
use League\Tactician\Handler\CommandHandlerMiddleware;
use League\Tactician\Handler\CommandNameExtractor\ClassNameExtractor;
use League\Tactician\Handler\Locator\InMemoryLocator;
use League\Tactician\Handler\MethodNameInflector\HandleInflector;

require_once __DIR__.'/../vendor/autoload.php';

$context = (new FsConnectionFactory('file://'))->createContext();
$context->purge($context->createQueue('queue'));

$queueMiddleware = new QueueMiddleware($context, 'queue');
$normalizerMiddleware = new NormalizerMiddleware(new NativePhpSerializer(), $context);
$handlerMiddleware = new CommandHandlerMiddleware(
    new ClassNameExtractor(),
    new InMemoryLocator([
        TaskCommand::class => new TaskHandler(),
        QueuedMessage::class => new QueuedMessageHandler(),
    ]),
    new HandleInflector()
);

$bus = new CommandBus([$normalizerMiddleware, $queueMiddleware, $handlerMiddleware]);

$bus->handle(new QueueMessage(new TaskCommand()));

$consumer = $context->createConsumer($context->createQueue('queue'));
if ($message = $consumer->receive(2000)) {
    echo 'Got message from MQ'.PHP_EOL;

    $processor = new TacticianProcessor($bus);
    $processor->process($message, $context);
    $consumer->acknowledge($message);
}

class TaskCommand
{
    public $message = 'Hello World!!!'.PHP_EOL;
}

class TaskHandler
{
    public function handle(TaskCommand $command)
    {
        echo $command->message, PHP_EOL;
    }
}

class QueuedMessageHandler
{
    public function handle()
    {
        echo 'Command has been queued'.PHP_EOL;
    }
}
