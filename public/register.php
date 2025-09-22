<?php
require_once dirname(__DIR__) . '/app/controllers/RegisterController.php';

$controller = new RegisterController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->register($_POST);
    exit;
}

$controller->showForm();
