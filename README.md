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


Class overview
--------------

The Execution packages provides the Execution class. This class provides the
full interface to catch "fatal" errors. The component also
provides the ExecutionErrorHandler interface for implementation by error
handlers. A basic error handler is supplied through the
ExecutionBasicErrorHandler class.


Usage
-----

Start your application by calling Execution::init( $className ) to
initialize the Execution class. $className is the name of the
class that implements your handler. In our first example, we will use the
default handler ExecutionBasicErrorHandler. Calling the init()
method sets up the environment and registers the necessary handlers with PHP.

Before your application quits with exit() or die(), you need to signal to the
Execution environment that your application exited properly. Without this
signal, the handlers assume that your application has ended unsuspectedly. The
onError() method of the class you specified with the init() method will thus be
called.

This is a basic example:

  Execution::init('ExecutionBasicErrorHandler');
  Execution::cleanExit();

In line 4, we initialize the environment and in line 6, we signal to the
environment that we have a clean exit. Otherwise, the script
would have displayed the following message: ::

  This application stopped in an unclean way.  Please contact the maintainer
  of this system and explain him that the system doesn't work properly at the
  moment.

  Have a nice day!

This is simply the default message and can be customized. To do so, create a new
class that implements the ExecutionErrorHandler interface. You will only
have to implement one method: onError(). In the next example, we create such a
class and implement a custom message:

  class MyExecutionHandler implements ExecutionErrorHandler
  {
    public static function onError( Exception $e = NULL )
    {
      if (!is_null($e))
      {
        $message = $e->getMessage();
      }
      else
      {
        $message = "Unclean Exit - Execution::cleanExit() was not called.";
      }

      echo "This application did not succesfully finish its request. ".
          "The reason was:\n$message\n\n";
    }
  }

  Execution::init('MyExecutionHandler');

  throw new Exception("Throwing an exception that will not be caught.");

  Execution::cleanExit();

In lines 4-20, we declare our handler class *MyExecutionHandler*, which
implements the ExecutionErrorHandler interface. Using the onError method, on
line 8 we check whether the error was caused by an uncaught
exception. In that case, we insert the exception's message into the $message
variable. Otherwise, we assign a static value to $message. $message is then
displayed in lines 17 and 18.

When you run the above script, the following warning is displayed: ::

    This application did not succesfully finish its request. The reason was:
    Throwing an exception that will not be caught.

This is due to line 24, where we throw an uncaught exception. If lines 24 and
26 are commented out, the result will instead be as follows: ::

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

There are two classes in this component:

### Execution

This class provides methods to intialize the class (with a static method) and
to signal clean and unclean exists.

### ExecutionBasicErrorHandler

This class implements a default handler that can be used and extended for use
with the execution framework.

Algorithms
----------

The following example shows how to utilize these classes: ::


  class myExecutionHandler extends ExecutionBasicErrorHandler
  {
    public function onError($exception = NULL)
    {
      echo "Error!\n";
      parent::onError($exception);
    }
  }

  Execution::init('myExecutionHandler');

  ....

  Execution::cleanExit();

Tests
-----

Go to `tests` directory and run `phpunit ExecutionTest`.

Credits
-------

Work is derivative of ezcExecution package of ezComponents, which was originally
developed by Sergey Alexeev, Sebastian Bergmannm, Jan Borsodim, Raymond Bosman,
Frederik Holljen, Kore Nordmann, Derick Rethans, Vadym Savchuk, Tobias Schlitt
and Alexandru Stanoi.
