<?php
require_once dirname(__DIR__) . '/app/controllers/ForgotPasswordController.php';

$controller = new ForgotPasswordController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->resetPassword($_POST);
    exit;
}

$controller->showForm();
