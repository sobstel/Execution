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

require dirname(__FILE__).'/../src/autoload.php';
require dirname(__FILE__).'/test_classes.php';

/**
 * @package Execution
 * @subpackage Tests
 */
class ExecutionTest extends PHPUnit_Framework_TestCase
{
  public function testCallbackExists()
  {
    Execution::reset();
    try
    {
      @Execution::init('ExecutionDoesNotExist');
      $this->fail("Expected exception was not thrown");
    }
    catch (ExecutionInvalidCallbackException $e)
    {
      $this->assertEquals("Class 'ExecutionDoesNotExist' does not exist.", $e->getMessage());
    }
  }

  public function testAlreadyInitialized()
  {
    Execution::reset();
    try
    {
      Execution::init('ExecutionTest2');
      Execution::init('ExecutionTest2');
      $this->fail("Expected exception was not thrown");
    }
    catch (ExecutionAlreadyInitializedException $e)
    {
      $this->assertEquals("The Execution mechanism is already initialized.", $e->getMessage());
    }
  }

  public function testReset()
  {
    Execution::reset();
    Execution::init('ExecutionTest2');
    Execution::reset();
    Execution::init('ExecutionTest2');
  }

  public function testInvalidCallbackClass()
  {
    Execution::reset();
    try
    {
      Execution::init('ExecutionTest1');
      $this->fail("Expected exception was not thrown");
    }
    catch (ExecutionWrongClassException $e)
    {
      $this->assertEquals("The class 'ExecutionTest1' does not implement the 'ExecutionErrorHandler' interface.", $e->getMessage());
    }
  }

  public function testCleanExitInitialized()
  {
    Execution::reset();
    Execution::init( 'ExecutionTest2' );
    Execution::cleanExit();
  }

  /**
   * Unfortunately this test is unable to work, because when the uncaught
   * exception would have been run, PHP aborts. So let's leave the test
   * commented out!
   *
  public function testUncaughtException()
  {
    Execution::reset();
    Execution::init( 'ExecutionBasicErrorHandler' );
    throw new Exception();
    Execution::reset();
  }
   */

  /**
   * This test would leave a warning when the unit test frameworks ends. As
   * there is no other way of testing this, please leave the test commented
   * out!
   *
  public function testUncleanExit()
  {
    Execution::reset();
    Execution::init( 'ExecutionBasicErrorHandler' );
  }
   */

}
