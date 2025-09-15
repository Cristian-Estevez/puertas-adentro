<?php
// public/index.php
// Front controller for the PHP application

// Load environment configuration
require_once dirname(__DIR__) . '/config/env.php';

// Example usage of environment variables
$environment = env('ENVIRONMENT', 'development');

// Set error reporting based on environment
if (ENV == "development") {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// Example logging based on environment
if (ENV == "development") {
    // Development logging
    error_log("Application started in development mode");
} else {
    // Production logging
    error_log("Application started in production mode");
}

header('Content-Type: text/plain');
echo "Hello, PHP World!\n";
echo "Environment: " . $environment . "\n";
echo "Is Development: " . (ENV == "development" ? 'Yes' : 'No') . "\n";
