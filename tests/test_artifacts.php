<?php
/**
 * This file is part of the Execution package.
 *
 * (c) 2011, Przemek Sobstel (http://sobstel.org).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Execution\Tests\Artifacts;

function some_func()
{    
}

class SomeClass
{
    static public function some_static_method()
    {        
    }
    
    public function some_method()
    {       
    }
}

$some_closure = function ()
{    
};

class CalledClass
{
    public $called = false;
    public $exception_passed = false;
    
    public function __invoke($e = null)
    {
        $this->called = true;
        if ($e instanceof \Exception) {
            $this->exception_passed = true;
        }
    }
}