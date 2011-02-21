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
 * @package Execution
 * @subpackage Tests
 */
class ExecutionTest1
{
}

/**
 * @package Execution
 * @subpackage Tests
 */
class ExecutionTest2 implements ExecutionErrorHandler
{
  static public function onError( Exception $e = NULL )
  {
    echo "\nThe Execution succesfully detected an unclean exit.\n";
    echo "Have a nice day!\n";
  }
}
