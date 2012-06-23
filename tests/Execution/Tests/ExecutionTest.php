<?php
/**
 * Execution
 *
 * @author Przemek Sobstel (http://sobstel.org)
 * @license The MIT License
 */

namespace Execution\Tests;

use Execution\Execution;
use Execution\Exception;

/**
 * @package Execution
 * @subpackage Tests
 */
class ExecutionTest extends \PHPUnit_Framework_TestCase {

  /**
   * @dataProvider invalidCallbacks
   * @expectedException \Execution\Exception\InvalidCallbackException
    */
  public function testThrowsExceptionOnInvalidCallback($callback) {
    Execution::setFatalErrorHandler($callback);
  }

  public function invalidCallbacks() {
    return array(
      array('fake_func'),
      array('FakeClass::fakeMethod')
    );
  }

}
