<?php
// public/index.php
// Front controller for the PHP application

// Load environment configuration
require_once dirname(__DIR__) . '/config/env.php';

// Load login utilities for authentication
require_once dirname(__DIR__) . '/app/utils/login-utils.php';

// Load View class for templates
require_once dirname(__DIR__) . '/app/classes/View.php';

// Load HomeController for regular users
require_once dirname(__DIR__) . '/app/controllers/HomeController.php';

require_once dirname(__DIR__) . '/app/controllers/AdminController.php';

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Require user to be logged in - redirects to login if not authenticated
require_login();

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

// Set content type
header('Content-Type: text/html; charset=UTF-8');

// Render view based on user role
$view = new View();

if (user_role() == 'admin') {
    // Render dashboard for admin users
    $adminController = new AdminController();
    $adminController->showView();
    exit; // Exit to prevent rendering the home view below
} else {
    // Use HomeController for regular users (includes posts data)
    $homeController = new HomeController();
    $homeController->showView();
    exit; // Exit to prevent rendering the admin view below
}
