<?php
require_once __DIR__.'/../src/Execution/ClassLoader/ClassLoader.php';

use Execution\ClassLoader\ClassLoader;

$loader = new ClassLoader();
$loader->register();

require_once __DIR__.'/test_artifacts.php';
