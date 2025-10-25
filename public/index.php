<?php

/*
 *---------------------------------------------------------------
 * BOOTSTRAP THE APPLICATION
 *---------------------------------------------------------------
 * This process sets up the path constants, loads and registers
 * the autoloader, and loads the framework's bootstrap file.
 */

// Ensure the current directory is pointing to the front controller's directory
chdir(__DIR__);

// Define FCPATH
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);

// Load our paths constants file and the application bootstrap
require_once FCPATH . '../app/Config/Paths.php';
$paths = new Config\Paths();

// Location of the framework bootstrap file.
require_once rtrim($paths->systemDirectory, '\\/ ') . DIRECTORY_SEPARATOR . 'bootstrap.php';

// Load environment settings from .env files into $_SERVER and $_ENV
require_once APPPATH . 'Config/Boot/development.php';

// Load environment settings from .env files into $_SERVER and $_ENV
require_once APPPATH . 'Config/Boot/production.php';

/*
 *---------------------------------------------------------------
 * LAUNCH THE APPLICATION
 *---------------------------------------------------------------
 * Now that everything is setup, it's time to actually fire
 * up the engines and make this app do its thang.
 */
$app = \Config\Services::codeigniter();
$app->run();
