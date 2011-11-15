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

/**
 * Interface for Execution callback handlers.
 *
 * This interface describes the methods that an Execution callback handler
 * should implement.
 *
 * For an example see {@link Execution}.
 *
 * @package Execution
 */
interface ErrorHandler
{

    /**
     * Processes an error situation
     *
     * This method is called by the Execution environment whenever an error
     * situation (uncaught exception or fatal error) happens.  It accepts one
     * default parameter in case there was an uncaught exception.
     *
     * @param Exception $e 
     * @return void
     */
    static public function onError(\Exception $e = null);
}
