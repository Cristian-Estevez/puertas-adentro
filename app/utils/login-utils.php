<?php
require_once dirname(__DIR__) . '/classes/Database.php';
require_once dirname(__DIR__) . '/models/User.php';

// ---------------------------------------------------------------------
// Utilidades de seguridad simples 
// - e(): escape HTML (anti-XSS al mostrar variables del usuario)
// - start_secure_session(): cookie HttpOnly + SameSite, rotación de ID y timeout
// - csrf_token()/csrf_check(): protección CSRF para formularios POST
// - validate_login_input(): validación/sanitización mínima para login
// ---------------------------------------------------------------------


// Global User instance for utility functions
$userModel = new User();

// ------------------------------------------------------------
// user_id()
// ------------------------------------------------------------
function user_id(): ?int {
    return $_SESSION['uid'] ?? null;
}


// ------------------------------------------------------------
// user_name()
// ------------------------------------------------------------
function user_name(): ?string {
    return $_SESSION['uname'] ?? null;
}


// ------------------------------------------------------------
// user_role()
// ------------------------------------------------------------
function user_role(): string {
    return $_SESSION['role'] ?? 'user';
}


// ------------------------------------------------------------
// require_login()
// ------------------------------------------------------------
function require_login(): void {
    if (!user_id()) {
        http_response_code(302);
        header('Location: /login.php');
        exit;
    }
}


// ------------------------------------------------------------
// require_admin()
// ------------------------------------------------------------
function require_admin(): void {
    if (!user_id() || user_role() !== 'admin') {
        http_response_code(403);
        exit('Prohibido');
    }
}
