<?php
/**
 * Execution
 *
 * @author Przemek Sobstel (http://sobstel.org)
 * @license The MIT License
 */

namespace Execution\Tests\ErrorHandler;

use Execution\ErrorHandler\BasicErrorHandler;

/**
 * @package Execution
 * @subpackage Tests
 */
class BasicErrorHandlerTest extends \PHPUnit_Framework_TestCase {

  public function testMustBeCallable() {
    $this->assertTrue(is_callable(new BasicErrorHandler()), 'BasicErrorHandler must be callable (should implement __invoke() method)');
  }

  public function testOutputsGeneralMessage() {
    $handler = new BasicErrorHandler();
    
    $prop = new \ReflectionProperty('\Execution\ErrorHandler\BasicErrorHandler', 'message');
    $prop->setAccessible(true);
    $message = $prop->getValue($handler);
    
    ob_start();
    $handler(array());
    $output = ob_get_clean();
    
    $this->assertEquals($message, $output);
  }
    
}
