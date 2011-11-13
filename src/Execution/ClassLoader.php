<?php
/**
 * This file is part of the Execution package.
 *
 * (c) 2011, Przemek Sobstel (http://sobstel.org).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Execution;

class ClassLoader {

  static private $base_path;
  
  static public function basePath() {
    if (empty(self::$base_path)) {
      self::$base_path = realpath(__DIR__.'/../..');
    }

    return self::$base_path;
  }
  
  static public function loadClass($classname) {
    $file = self::basePath().'/src/'.str_replace('\\', '/', $classname).'.php';
    if (file_exists($file)) {
      require_once $file;
    }
  }

}
