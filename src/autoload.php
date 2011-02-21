<?php
/**
 * This file is part of the Execution package.
 *
 * (c) 2011, Przemek Sobstel (http://sobstel.org).
 * (c) 2005-2008, eZ Systems A.S.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require_once dirname(__FILE__).'/Execution/Execution.php';

require_once dirname(__FILE__).'/Execution/ExecutionErrorHandler.php';
require_once dirname(__FILE__).'/Execution/ExecutionBasicErrorHandler.php';

require_once dirname(__FILE__).'/Execution/ExecutionException.php';
require_once dirname(__FILE__).'/Execution/ExecutionAlreadyInitializedException.php';
require_once dirname(__FILE__).'/Execution/ExecutionInvalidCallbackException.php';
require_once dirname(__FILE__).'/Execution/ExecutionNotInitializedException.php';
require_once dirname(__FILE__).'/Execution/ExecutionWrongClassException.php';
