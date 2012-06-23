<?php
/**
 * Execution
 *
 * @author Przemek Sobstel (http://sobstel.org)
 * @license The MIT License
 */

namespace Execution\Exception;

/**
 * Thrown when an invalid callback was passed.
 * 
 * @package Execution
 */
class InvalidCallbackException extends Exception {

  /**
   * @param mixed $callback
   */
  function __construct($callback) {
    parent::__construct("Callback is not callable.");
  }

}
