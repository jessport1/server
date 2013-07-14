<?php

ini_set ( "memory_limit", "256M" );

require_once(__DIR__ . "/../../../../batch/bootstrap.php");

/**
 * Executes the KAsyncDropFolderWatcher
 * 
 * @package plugins.dropFolder
 * @subpackage Scheduler
 */

$instance = new KAsyncDropFolderWatcher();
$instance->run(); 
$instance->done();
