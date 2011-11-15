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

namespace Execution\ErrorHandler;

/**
 * Simple implementation of a callback handler to use with Execution.
 *
 * This is a very simple callback handler which only issues a simple message.
 * Of course in applications you will need to either extend this class, or just
 * implement the ExecutionErrorHandler interface.
 *
 * @package Execution
 */
class BasicErrorHandler implements ErrorHandlerInterface
{

    /**
     * Processes an error situation
     *
     * This method is called by the Execution environment whenever an error
     * situation (uncaught exception or fatal error) happens.  It accepts one
     * default parameter in case there was an uncaught exception.
     *
     * This class just serves as an example, for your own application you
     * should write your own class that implements the ExecutionErrorHandler
     * interface and use that as parameter to {@link Execution::init()}
     *
     * @param Exception $e
     * @return void
     */
    static public function onError(\Exception $e = null)
    {
        echo <<<END
This application stopped in an unclean way. Please contact the site
administrator to report the error.

Have a nice day!

END;
    }

}
