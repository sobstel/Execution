<?php

/**
 * This file is part of the Execution package.
 *
 * (c) 2011, Przemek Sobstel (http://sobstel.org).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Execution\Tests;

use Execution\Execution;
use Execution\Exception;

/**
 * @package Execution
 * @subpackage Tests
 */
class ExecutionTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        Execution::reset();
    }

    public function tearDown()
    {
        Execution::reset();
        Execution::cleanExit();
    }

    public function testCanResetEnvironment() {
        $this->setPropertyValue('isInitialized', '_fake_');
        $this->setPropertyValue('callback', '_fake_');
        $this->setPropertyValue('cleanExit', '_fake_');
       
        Execution::reset();

        $this->assertAttributeEquals(false, 'isInitialized', '\Execution\Execution');
        $this->assertAttributeEquals(null, 'callback', '\Execution\Execution');
        $this->assertAttributeEquals(false, 'cleanExit', '\Execution\Execution');        
    }

    /**
     * @dataProvider invalidCallbacks
     * @expectedException \Execution\Exception\InvalidCallbackException
     */
    public function testThrowsExceptionOnInvalidCallback($callback)
    {
        Execution::init($callback);
    }

    public function invalidCallbacks()
    {
        return array(
            array('fake_func'),
            array('FakeClass::fakeMethod')
        );
    }

    private function callbackTest($callback)
    {
        $exception_thrown = false;
        try {
            Execution::init($callback);
        } catch (Exception\InvalidCallbackException $e) {
            $exception_thrown = true;
        }
        $this->assertFalse($exception_thrown, 'Exception should not be thrown on valid callback');
    }

    public function testCallbackCanBeFunction()
    {
        $this->callbackTest('Execution\Tests\Artifacts\some_func');
    }

    public function testCallbackCanBeClassMethod()
    {
        Execution::reset();
        $this->callbackTest('\Execution\Tests\Artifacts\SomeClass::some_static_method');
        
        Execution::reset();
        $this->callbackTest(array('\Execution\Tests\Artifacts\SomeClass', 'some_static_method'));
        
        Execution::reset();
        $some_obj = new \Execution\Tests\Artifacts\SomeClass();
        $this->callBackTest(array($some_obj, 'some_method'));
    }

    public function testCallbackCanBeClosure()
    {
        $this->callbackTest(function(){});
    }

    /**
     * @expectedException \Execution\Exception\AlreadyInitializedException
     */
    public function testThrowsExceptionWhenInitializingAlreadyInitialized()
    {
        $this->setPropertyValue('isInitialized', true);
        
        Execution::init(function(){});
    }

    public function testRegistersCustomExceptionHandler()
    {
        Execution::init(function(){});
        
        $org_exception_handler = set_exception_handler(function(){});
        $this->assertEquals($org_exception_handler, '\Execution\Execution::exceptionCallbackHandler');
        
        restore_exception_handler();
    }
    
    public function testCanInitialize()
    {
        $closure = function(){};

        Execution::init($closure);

        $this->assertEquals($closure, $this->getPropertyValue('callback'));
        $this->assertEquals(true, $this->getPropertyValue('isInitialized'));
        $this->assertEquals(false, $this->getPropertyValue('cleanExit'));
        $this->assertEquals(true, $this->getPropertyValue('shutdownHandlerRegistered'));
    }

    public function testCanCleanExit() {
        $this->setPropertyValue('cleanExit', false);        
        Execution::cleanExit();
        $this->assertEquals(true, $this->getPropertyValue('cleanExit'));
    }

    public function testCallbackCalledByExceptionHandler()
    {
        $obj = new Artifacts\CalledClass();
        Execution::init($obj);
        
        Execution::exceptionCallbackHandler(new \Exception());
        
        $this->assertEquals(true, $obj->called);
        $this->assertEquals(true, $obj->exception_passed);
    }
    
    public function testCallbackCalledByShutdownHandler()
    {
        $obj = new Artifacts\CalledClass();
        Execution::init($obj);
        
        Execution::shutdownCallbackHandler(new \Exception());
        
        $this->assertEquals(true, $obj->called);
        $this->assertEquals(false, $obj->exception_passed);
        $this->assertEquals(true, $this->getPropertyValue('cleanExit'));
    }

    public function testCallbackNotCalledByShutdownHandlerWhenCleanExit()
    {
        $obj = new Artifacts\CalledClass();
        Execution::init($obj);        
        Execution::cleanExit();        
        Execution::shutdownCallbackHandler(new \Exception());
        
        $this->assertEquals(false, $obj->called);
        $this->assertEquals(false, $obj->exception_passed);
        $this->assertEquals(true, $this->getPropertyValue('cleanExit'));
    }

    private function makePropertyAccessible($name) {
        $ref_prop = new \ReflectionProperty('\Execution\Execution', $name);
        $ref_prop->setAccessible(true);
        return $ref_prop;
    }
    
    private function setPropertyValue($name, $value)
    {
        $ref_prop = $this->makePropertyAccessible($name);
        $ref_prop->setValue('\Execution\Execution', $value);
        return $ref_prop;
    }

    private function getPropertyValue($name)
    {
        $ref_prop = $this->makePropertyAccessible($name);
        return $ref_prop->getValue('\Execution\Execution', $name);
    }
}
