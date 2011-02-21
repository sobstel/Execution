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

/**
 * Thrown when the Execution framework was already initialized.
 * 
 * @package Execution
 */
class ExecutionAlreadyInitializedException extends ExecutionException
{
    function __construct()
    {
        parent::__construct("The Execution mechanism is already initialized.");
    }
}
