<?php
session_start();

// si no está logueado → lo mando al login
if (!isset($_SESSION['user_id'])) {
    header("Location: /index.php");
    exit;
}

// incluyo la vista principal del home
include __DIR__ . '/../views/home/main.php';

