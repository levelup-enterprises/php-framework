<?php require_once("./src/config/index.php");

use Controllers\Router;
use Controllers\Link;
use Utilities\Browser;

// Check if ie browser
$isIE = Browser::isIE();

// Start router
$router = new Router;

// Setup page links
$link = new Link;

// Bring in frontend
require __DIR__ . $router->route();

// Close any open connections
isset($db) && $db->disconnect(); 
