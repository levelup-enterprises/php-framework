<?php

///////////////////////////////
//* Vendor Library
///////////////////////////////

require_once(__DIR__ . '/../../vendor/autoload.php');

// Declare libraries
use Utilities\DB;
use Http\Session;
use Controllers\Router;
use Controllers\Link;
use Http\Request;
use Utilities\Browser;

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

// Set ajax allowed directory
define('SCRIPTS', 'src/');

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

$session = new Session;
$router = new Router;
$link = new Link;

// Connect DB
$db = (new DB)->start();

///////////////////////////////
//* Authenticate Request
///////////////////////////////

// Request::handleRequest();
