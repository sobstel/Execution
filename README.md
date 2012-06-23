Execution
=========

Introduction
------------

When there is a problem with your web application, you do not want your
visitors to see "fatal error" messages. Instead you want to be able to show
them a more friendly page telling them what might be wrong or what they should
do when they encounter such an error.

Fatal errors in PHP abort your script, but with this library you can add hooks 
to the shutdown system of PHP. This allows you to show more user-friendly error 
messages.

Requirements
------------

PHP 5.3+

Class loading
-------------

Library can be loaded by including Execution.php file, it's also psr0 compatible.

    // plain old require_once
    require_once 'src/Execution/Execution.php';

    // symfony2 autoloader
    $loader = new \Symfony\Component\ClassLoader\UniversalClassLoader();
    $loader->registerNamespaces(array(
        'Execution' => 'vendor/Execution/src',
    ));
    $loader->register();

Usage
-----

Call *Execution\Execution::setErrorHandler($callback)* to initialize. 
*$callback* is any valid callback (array, string, closure, invokable
object). *setErrorHandler* registers the necessary handlers with PHP.

Callback should expect one argument, which is associative array 
having following keys:

    [type] => 1
    [message] => Call to undefined function a()
    [file] => /var/www/app/index.php
    [line] => 12

Sample callback:

    $callback = function($error) {
      $message = $error['message'];

      echo "This application did not succesfully finish its request. ".
            "The reason was:\n$message\n\n";
    }

    Execution\Execution::setErrorHandler($callback);

The library uses the register_shutdown_function() to allow the catching 
of fatal errors.

Tests
-----

Simply type `phpunit tests` to run all tests.

Credits
-------

Version 1.0 is derivative of ezcExecution package of ezComponents, which was originally
developed by Sergey Alexeev, Sebastian Bergmannm, Jan Borsodim, Raymond Bosman,
Frederik Holljen, Kore Nordmann, Derick Rethans, Vadym Savchuk, Tobias Schlitt
and Alexandru Stanoi. 

Major improvements in comparison with original ezcComponent:

  - you can pass any callback, including closures and invokable objects (it is 
    if they have __invoke() method implemented),
  - slimed and simplified,
  - rewritten tests (100% code coverage).

Version 2.0 has been re-written from the scratch with more simplicity in mind.
Credits go for my co-worker Paul Kamer, who used this trick in our code.
