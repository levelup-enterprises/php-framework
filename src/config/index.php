<?php

///////////////////////////////
//* Vendor Library
///////////////////////////////

require_once(__DIR__ . '/../../vendor/autoload.php');

// Declare libraries
use Utilities\DB;
use Http\Session;

///////////////////////////////
//* Project Variables
///////////////////////////////

// Site Info --------------------------- //

// Set site title
define('TITLE', 'PHP Starter');

// Set production url
define('PROD_URL', 'www.phpstarter.com');

// Set current version
define('VERSION', '1.0');

// ------------------------------------ //

// Set DB connection info
define('DBDATA', include('db.php'));

// Set Session timeout
define('TIMEOUT', 1800); // 30 mins 1800

// Set views directory
define('VIEWS', 'templates/');

// Set Stage Env
define('STAGE', true);

// Set the default timezone
date_default_timezone_set('America/Chicago');

// Set local Env
if ($_SERVER["REMOTE_ADDR"] === '127.0.0.1') {
define('LOCAL', true);
} else {
define('LOCAL', false);
}

///////////////////////////////
//* Error Handling
///////////////////////////////

if (!STAGE) {
    error_reporting(E_ALL ^ E_WARNING);
} else {
    error_reporting(E_ALL);
    ini_set("display_errors", "On");
}

///////////////////////////////
//* Initialize Classes
///////////////////////////////

// Connect DB
$conn = new DB();
$db = $conn->start();

// Start sessions
$session = new Session;