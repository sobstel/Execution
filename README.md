Execution
=========

Introduction
------------

When there is a problem with your web application, you do not want your
visitors to see "fatal error" messages. Instead you want to be able to show
them a more friendly page telling them what might be wrong or what they should
do when they encounter such an error.

Fatal errors and uncaught exceptions in PHP abort your script, but with this
component you can add hooks to the shutdown system of PHP. This allows you to
show more user-friendly error messages.

Requirements
------------

PHP 5.3+

Class overview
--------------

The Execution packages provides the Execution class. This class provides the
full interface to catch "fatal" errors. The component also
provides the BasicErrorHandler as an example for error handling callback.

Class loader
------------

Component comes with its own class loader, but can be used with any psr0
compatible autoloader.

    // built-in autoloader
    require_once 'src/Execution/ClassLoader/ClassLoader.php';
    use Execution\ClassLoader\ClassLoader;
    $loader = new ClassLoader();
    $loader->register();

    // symfony2 autoloader
    require_once 'vendor/symfony/src/Symfony/Component/ClassLoader/UniversalClassLoader.php';
    use new Symfony\Component\ClassLoader;
    $loader = new ClassLoader\UniversalClassLoader();
    $loader->registerNamespaces(array(
        'Execution' => 'vendor/Execution/src',
    ));
    $loader->register();

Usage
-----

Start your application by calling Execution\Execution::init($callback) to
initialize. $callback is any valid callback (array, string, closure, invokable
object). Calling the init() method sets up the environment and registers the 
necessary handlers with PHP.

Before your application quits with exit() or die(), you need to signal to the
Execution environment that your application exited properly. Without this
signal, the handlers assume that your application has ended unsuspectedly. 
Callback that you specified with the init() method will thus be called.

This is a basic example:

    Execution\Execution::init(new \Execution\ErrorHandler\BasicErrorHandler);
    Execution\Execution::cleanExit();

We initialize the environment and then we signal to the environment that we have 
a clean exit. Otherwise, the script would have displayed the following message:

    This application stopped in an unclean way. Please contact the site
    administrator to report the error.

\Execution\ErrorHandler\BasicErrorHandler is valid callback as it implements
magic __invoke() method.

This is simply the default message and can be customized. To do so, create a new
class that implements the ExecutionErrorHandler interface. You will only
have to implement one method: onError(). In the next example, we create such a
class and implement a custom message:

    class MyExecutionHandler
    {
      public static function __invoke(\Exception $e = NULL)
      {
        if (!is_null($e)) {
          $message = $e->getMessage();
        } else {
          $message = "Unclean Exit - Execution::cleanExit() was not called.";
        }

        echo "This application did not succesfully finish its request. ".
            "The reason was:\n$message\n\n";
      }
    }

    Execution::init(new MyExecutionHandler());

    throw new Exception("Throwing an exception that will not be caught.");

    Execution::cleanExit();

First we declare our handler class *MyExecutionHandler*, which implements the 
magic __invoke method. Then we check whether the error was caused by an uncaught
exception. In that case, we insert the exception's message into the $message
variable. Otherwise, we assign a static value to $message. $message is then
displayed.

When you run the above script, the following warning is displayed:

    This application did not succesfully finish its request. The reason was:
    Throwing an exception that will not be caught.

This is due to an uncaught exception being thrown by us. If it's commented out, 
the result will instead be as follows:

    This application did not succesfully finish its request. The reason was:
    Unclean Exit - Execution::cleanExit() was not called.

Design Description
------------------
The component uses the register_shutdown_function() and set_execution_handler()
to allow the catching of fatal errors and uncatched exceptions. At the start of
the script you need to initialize the execution environment and when your
application is done executing you signal the component that you have a "clean
exit".  In case there was not a clean exit the shutdown handler will pick up
and call your defined callback handler to display the error message.

Tests
-----

Simply type `phpunit tests` to run all tests.

Credits
-------

Work is derivative of ezcExecution package of ezComponents, which was originally
developed by Sergey Alexeev, Sebastian Bergmannm, Jan Borsodim, Raymond Bosman,
Frederik Holljen, Kore Nordmann, Derick Rethans, Vadym Savchuk, Tobias Schlitt
and Alexandru Stanoi.

Major improvements in comparison with original ezcComponent:

  - you can pass any callback, including closures and invokable objects (it is 
    if they have __invoke() method implemented),
  - slimed and simplified,
  - rewritten tests (100% code coverage).
