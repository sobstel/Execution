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

namespace Execution\Exception;

/**
 * Thrown when the Execution framework was not initialized when cleanExit()
 * was called.
 * 
 * @package Execution
 */
class NotInitializedException extends Exception
{

    function __construct()
    {
        parent::__construct("The Execution mechanism was not initialized.");
    }

}
