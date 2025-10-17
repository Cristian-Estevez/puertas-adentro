<?php
require_once dirname(__DIR__) . '/config/env.php';
require_once dirname(__DIR__) . '/app/utils/login-utils.php';
require_once dirname(__DIR__) . '/app/classes/View.php';
require_once dirname(__DIR__) . '/app/controllers/HomeController.php';

// Checks if session is started and starts it if not
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirects to login if user is not authenticated
require_login();

$controller = new HomeController();
$html = $controller->showView();
echo $html;