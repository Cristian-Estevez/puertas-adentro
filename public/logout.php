<?php
require_once dirname(__DIR__) . '/app/controllers/LoginController.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$controller = new LoginController();
$controller->logout();


