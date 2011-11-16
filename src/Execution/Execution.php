<?php

/**
 * This file is part of the Execution package.
 *
 * (c) 2011, Przemek Sobstel (http://sobstel.org).
 * (c) 2005-2008, eZ Systems A.S.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Execution;

use Execution\Exception;

/**
 * Class for handling fatal errors and uncaught exceptions
 *
 * This class allows you to invoke a handler whenever a fatal error occurs, or
 * when an uncatched exception happens.  You can specify which callback
 * function to use and signal whether your application cleanly exited.
 *
 * Example:
 * <code>
 * <?php
 * class myExecutionHandler
 * {
 *     public function __invoke(\Exception $exception = null)
 *     {
 *         echo "Error!\n";
 *     }
 * }
 * 
 * Execution\Execution::init('myExecutionHandler');
 * 
 * // ....
 * 
 * Execution\Execution::cleanExit();
 * ?>
 * </code>
 *
 * @package Execution
 */
class Execution
{

    /**
     * Used for keeping a record whether the Execution mechanism was
     * initialized through the init() method.
     * @var bool
     */
    static private $isInitialized = false;

    /**
     * Contains the callback that is going to be called the when an error occurs.
     * @var string
     */
    static private $callback = null;

    /**
     * Records whether we had a clean exit from the application or not. 
     * If it's false then the shutdownCallbackHandler() method will not call 
     * the callback.
     * @var bool
     */
    static private $cleanExit = false;

    /**
     * A shutdown handler can not be removed, and that's why this static
     * property records if it was set or not. This ensures that the class will
     * only set the shutdown handler once over the lifetime of a request.
     * @var bool
     */
    static private $shutdownHandlerRegistered = false;

    /**
     * Initializes the Execution environment.
     *
     * You need to specify a callback $callBack that will be called in case of 
     * an error.
     * 
     * This method takes care of registering the uncaught exception and shutdown
     * handlers.
     *
     * @throws Execution\Exception\InvalidCallbackException if an unknown 
     *         callback class was passed.
     * @throws Execution\Exception\AlreadyInitializedException if the environment
     *         was already initialized.
     *
     * @param mixed $callback
     * @return void
     * 
     * @api
     */
    static public function init($callback)
    {
        if (!is_callable($callback)) {
            throw new Exception\InvalidCallbackException($callback);
        }

        if (self::$isInitialized) {
            throw new Exception\AlreadyInitializedException();
        }

        set_exception_handler('\Execution\Execution::exceptionCallbackHandler');
        if (!self::$shutdownHandlerRegistered) {
            register_shutdown_function('\Execution\Execution::shutdownCallbackHandler');
        }

        self::$callback = $callback;
        self::$isInitialized = true;
        self::$cleanExit = false;
        self::$shutdownHandlerRegistered = true;
    }

    /**
     * Marks the current application as cleanly-exited.
     *
     * With this method you signal the Execution environment that your
     * application ended without errors. This is usually done just before you
     * reach the end of your script, or just before you call
     * {@link http://www.php.net/exit exit()} or
     * {@link http://www.php.net/die die()}.
     *
     * @return void
     * 
     * @api
     */
    static public function cleanExit()
    {
        self::$cleanExit = true;
    }

    /**
     * Resets the Execution environment.
     *
     * Usually this method should not be used, but in the rare cases when you 
     * want to restart the environment this is the method to use.
     *
     * @return void
     * 
     * @api
     */
    static public function reset()
    {
        if (self::$isInitialized) {
            restore_exception_handler();
        }
        self::$isInitialized = false;
        self::$callback = null;
        self::$cleanExit = false;
    }

    /**
     * Handler for uncaught exceptions.
     *
     * The Execution environment installs this method as handler for
     * uncaught exceptions and will be called when one is found.  This method's
     * only function is to call the callback set with the init() method. 
     * It passes along the uncaught exception to this method.
     *
     * @param \Exception $e
     * @return void
     */
    static public function exceptionCallbackHandler(\Exception $e)
    {
        self::cleanExit();
        call_user_func(self::$callback, $e);
    }

    /**
     * Shutdown handler.
     *
     * The Execution environment installs this method as general shutdown handler.
     * This method's only function is to call the callback set with the init() 
     * method.
     *
     * @return void
     */
    static public function shutdownCallbackHandler()
    {
        if (!self::$cleanExit) {
            self::cleanExit();
            call_user_func(self::$callback);
        }
    }

}
