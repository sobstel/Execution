<?php

/**
 * This file is part of the Execution package.
 *
 * (c) 2011, Przemek Sobstel (http://sobstel.org).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Execution\ClassLoader;

/**
 * Loader for classes that can be registered on SPL autoload stack
 * 
 * Usage:
 * <code>
 * $loader = new ClassLoader();
 * $loader->register();
 * </code>
 * 
 * @package Execution
 */
class ClassLoader {
  
  private $base_path;
  
  public function __construct($base_path = null) {
    if ($base_path === null) {
      $base_path = realpath(__DIR__.'/../..');
    }
    $this->base_path = $base_path;
  }
  
  public function getBasePath() {
    return $this->base_path;
  }

  public function loadClass($classname) {
    $file = $this->getBasePath().'/'.str_replace('\\', '/', $classname).'.php';
    if (file_exists($file)) {
      require_once $file;
    }
  }

  public function register() {
    spl_autoload_register($this->getAutoloadCallback());
  }

  public function getAutoloadCallback() {
    return array($this, 'loadClass');
  }

}
