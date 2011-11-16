<?php

/**
 * This file is part of the Execution package.
 *
 * (c) 2011, Przemek Sobstel (http://sobstel.org).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Execution\Tests\ClassLoader;

use Execution\ClassLoader\ClassLoader;

/**
 * @package Execution
 * @subpackage Tests
 */
class ClassLoaderTest extends \PHPUnit_Framework_TestCase
{

    public function getClasses()
    {
        return array(
            array('Execution\Execution'),
            array('Execution\ClassLoader\ClassLoader'),
            array('Execution\ErrorHandler\BasicErrorHandler'),
            array('Execution\Exception\Exception'),
            array('Execution\Exception\AlreadyInitializedException'),
            array('Execution\Exception\InvalidCallbackException'),
        );
    }

    public function testRegistersAutoloadCallback()
    {
        $class_loader = new ClassLoader();
        $class_loader->register();
        $this->assertContains($class_loader->getAutoloadCallback(), spl_autoload_functions());
        spl_autoload_unregister($class_loader->getAutoloadCallback());
    }

    /**
     * @dataProvider getClasses
     */
    public function testAutoloadsClasses($classname)
    {
        $class_loader = new ClassLoader();
        $class_loader->loadClass($classname);
        $this->assertTrue(class_exists($classname));
    }

}
