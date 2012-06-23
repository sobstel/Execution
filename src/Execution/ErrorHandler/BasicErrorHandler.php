<?php
/**
 * Execution
 *
 * @author Przemek Sobstel (http://sobstel.org)
 * @license The MIT License
 */

namespace Execution\ErrorHandler;

/**
 * Simple implementation of a callback handler to use with Execution.
 *
 * This is a very simple callback handler which only issues a simple message.
 *
 * @package Execution
 */
class BasicErrorHandler {

    private $message = <<<END
This application stopped unexpectedly. Please contact the site
administrator to report the error.
END;

  /**
   * Processes an error situation
   *
   * This method is called by the Execution environment whenever fatal error
   * happens. It accepts one default parameter (array), which is output of
   * error_get_last() function result.
   *
   * @param array
   * @return void
   */
  public function __invoke($error) {
    echo $this->message;
  }

}
