<?php

/**
 * This file is part of the Execution package.
 *
 * (c) 2011, Przemek Sobstel (http://sobstel.org).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Execution\Tests\ErrorHandler;

use Execution\ErrorHandler\BasicErrorHandler;

/**
 * @package Execution
 * @subpackage Tests
 */
class BasicErrorHandlerTest extends \PHPUnit_Framework_TestCase
{

    public function testMustBeCallable()
    {
        $this->assertTrue(is_callable(new BasicErrorHandler()), 'BasicErrorHandler must be callable (should implement __invoke() method)');
    }

    public function testOutputsGeneralMessage()
    {
        $handler = new BasicErrorHandler();
        
        $prop = new \ReflectionProperty('\Execution\ErrorHandler\BasicErrorHandler', 'message');
        $prop->setAccessible(true);
        $message = $prop->getValue($handler);
        
        ob_start();
        $handler();
        $output = ob_get_clean();
        
        $this->assertEquals($message, $output);
    }
    
}
