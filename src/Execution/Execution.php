<?php
/**
 * Execution
 *
 * @author Przemek Sobstel (http://sobstel.org)
 * @license The MIT License
 */

namespace Execution;

use Execution\Exception;

require_once __DIR__.'/ErrorHandler/BasicErrorHandler.php';
require_once __DIR__.'/Exception/Exception.php';
require_once __DIR__.'/Exception/InvalidCallbackException.php';

/**
 * Class for handling unrecoverable fatal errors.
 *
 * This class allows you to invoke a handler whenever a fatal error occurs.
 * You can specify which callback function to use.
 *
 * Example:
 * <code>
 * <?php
 * class myExecutionHandler {
 *   public function __invoke(array $error) {
 *     echo "Error!\n";
 *   }
 * }
 * 
 * Execution\Execution::setFatalErrorHandler('myExecutionHandler');
 * ?>
 * </code>
 *
 * @package Execution
 */
class Execution {

  static private $shutdown_function_registered = false;

  static private $callbacks = array();

  /**
   * Sets a user-defined fatal error handler function.
   *
   * @param callable $callback
   * @return void
   */
  static public function setFatalErrorHandler($callback) {
    if (!is_callable($callback)) {
      throw new Exception\InvalidCallbackException($callback);
    }

    self::$callbacks[] = $callback;

    if (!self::$shutdown_function_registered) {
      register_shutdown_function(array('Execution\Execution', 'shutdownFunction'));
      self::$shutdown_function_registered = true;
    }
  }

  /**
   * Restores the previous error handler function.
   *
   * @return bool This method always returns TRUE.
   */
  static public function restoreFatalErrorHandler() {
    array_pop(self::$callbacks);
    return true;
  }

  /**
   * Shutdown handler.
   *
   * This function is installed as general shutdown handler. This method's only 
   * purpose is to call the callback set with the setFatalErrorHandler() method.
   *
   * It's not meant to be called directly.
   *
   * @access private
   * @return void
   */
  static public function shutdownFunction() {
    $callback = end(self::$callbacks);
    $error = error_get_last();
      
    if ($callback && $error && self::isFatalError($error)) {
      call_user_func($callback, $error);
    }
  }

  /**
   * @return bool
   */
  static private function isFatalError($error) {
    return in_array($error['type'], array(E_ERROR, E_CORE_ERROR, E_COMPILE_ERROR));
  }

  private function __construct() {
  }

}
