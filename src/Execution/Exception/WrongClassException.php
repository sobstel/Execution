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
 * Thrown when the passed classname does not represent a class that
 * implements the ExecutionErrorHandler interface.
 * 
 * @package Execution
 */
class WrongClassException extends Exception
{

    /**
     * @param string $callbackClassName
     */
    function __construct($callbackClassName)
    {
        parent::__construct("The class '{$callbackClassName}' does not implement the 'Execution\ErrorHandler' interface.");
    }

}
