# Queue interop transport for Tactician  

## Useage

```php
<?php
use Enqueue\AmqpLib\AmqpConnectionFactory;
use League\Tactician\CommandBus;
use League\Tactician\Handler\CommandHandlerMiddleware;
use League\Tactician\Handler\CommandNameExtractor\ClassNameExtractor;
use League\Tactician\Handler\Locator\InMemoryLocator;
use League\Tactician\Handler\MethodNameInflector\HandleInflector;
use Enqueue\Tactician\Interop\Impl\AmqpInteropMiddlewareTransport;
use Enqueue\Tactician\Interop\Impl\InteropQueueMiddlewareTransport;
use Enqueue\Tactician\Interop\Impl\NativePhpSerializer;
use Enqueue\Tactician\Interop\InteropMiddleware;
use League\Tactician\Plugins\LockingMiddleware;
require_once 'vendor/autoload.php';
class TaskCommand
{
    public $message = 'Hello World!!!';
}
class TaskHandler
{
    public function handle(TaskCommand $command) {
        echo $command->message, PHP_EOL;
    }
}
$handlerMiddleware = new CommandHandlerMiddleware(
    new ClassNameExtractor(),
    new InMemoryLocator([
        TaskCommand::class => new TaskHandler(),
    ]),
    new HandleInflector()
);
$lockingMiddleware = new LockingMiddleware();
//
$context = (new AmqpConnectionFactory('amqp://'))->createContext();
$trans = new AmqpInteropMiddlewareTransport($context, 'queue');
$intMiddle = new InteropMiddleware($trans, new NativePhpSerializer());
//
$bus = new CommandBus([
    $lockingMiddleware,
    $intMiddle,
    $handlerMiddleware,
]);
//$bus->handle(new TaskCommand());
$consumer = $context->createConsumer($context->createQueue('queue'));
$processor = new \Enqueue\Tactician\Interop\InteropMiddlewareProcessor($bus);
while (true) {
    if ($message = $consumer->receive()) {
        $processor->process($message, $context);
        $consumer->acknowledge($message);
        sleep(1);
    }
}
```

## Developed by Forma-Pro

Forma-Pro is a full stack development company which interests also spread to open source development. 
Being a team of strong professionals we have an aim an ability to help community by developing cutting edge solutions in the areas of e-commerce, docker & microservice oriented architecture where we have accumulated a huge many-years experience. 
Our main specialization is Symfony framework based solution, but we are always looking to the technologies that allow us to do our job the best way. We are committed to creating solutions that revolutionize the way how things are developed in aspects of architecture & scalability.

If you have any questions and inquires about our open source development, this product particularly or any other matter feel free to contact at opensource@forma-pro.com

## License

It is released under the [MIT License](LICENSE).
