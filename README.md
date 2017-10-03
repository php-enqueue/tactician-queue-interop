# Queue interop transport for Tactician  

## Usage:

Take a look at [example/queue_command_example.php](example/queue_command_example.php). 
The example demonstrate how to queue a command to a MQ and process later in a different process.
Here's how to get started with it:
 
```bash
$ git clone git@github.com:php-enqueue/tactician-queue-interop.git && cd tactician-queue-interop
$ composer install 
$ php example/queue_command_example.php 
```

The expected output is:

``` 
Command has been queued
Got message from MQ
Hello World!!!

```

## Developed by Forma-Pro

Forma-Pro is a full stack development company which interests also spread to open source development. 
Being a team of strong professionals we have an aim an ability to help community by developing cutting edge solutions in the areas of e-commerce, docker & microservice oriented architecture where we have accumulated a huge many-years experience. 
Our main specialization is Symfony framework based solution, but we are always looking to the technologies that allow us to do our job the best way. We are committed to creating solutions that revolutionize the way how things are developed in aspects of architecture & scalability.

If you have any questions and inquires about our open source development, this product particularly or any other matter feel free to contact at opensource@forma-pro.com

## License

It is released under the [MIT License](LICENSE).
