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
 * Thrown when an non-existend class was passed as callback handler.
 * 
 * @package Execution
 */
class InvalidCallbackException extends Exception
{

    /**
     * @param string $callbackClassName
     */
    function __construct($callbackClassName)
    {
        parent::__construct("Class '{$callbackClassName}' does not exist.");
    }

}
