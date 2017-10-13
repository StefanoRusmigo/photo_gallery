<?php

// Define the core paths
// Define them as absolute paths to make sure that require_once works as expected

// DIRECTORY_SEPARATOR is a PHP pre-defined constant
// (\ for Windows, / for Unix)
defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);

defined('SITE_ROOT') ? null : 
	define('SITE_ROOT', DS.'var'.DS.'www'.DS.'html'.DS.'photo_gallery');



defined('LIB_PATH') ? null : define('LIB_PATH', SITE_ROOT.DS.'private'.DS.'includes');

// load config file first
require_once(LIB_PATH.DS.'config.php');

// load basic functions next so that everything after can use them
require_once(LIB_PATH.DS.'functions.php');

// load core objects
require_once(LIB_PATH.DS.'session.php');
require_once(LIB_PATH.DS.'database.php');

// load database-related classes
require_once(LIB_PATH.DS.'database_object.php');
require_once(LIB_PATH.DS.'user.php');

?>