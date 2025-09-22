<?php
/**
 * Debug Login Process
 * 
 * This script simulates the exact login process to identify issues
 */

require_once 'config/env.php';
require_once 'app/classes/Database.php';
require_once 'app/models/User.php';

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

echo "=== Login Process Debug ===\n\n";

// Simulate form data
$login = 'admin';
$password = 'password';

echo "Testing with:\n";
echo "Login: $login\n";
echo "Password: $password\n\n";

// Step 1: Check input validation
echo "Step 1: Input Validation\n";
$errors = [];
if ($login === '') $errors[] = 'El usuario o email es obligatorio.';
if ($password === '') $errors[] = 'La contraseña es obligatoria.';

if ($errors) {
    echo "❌ Validation errors:\n";
    foreach ($errors as $error) {
        echo "  - $error\n";
    }
    exit;
}
echo "✅ Input validation passed\n\n";

// Step 2: Find user
echo "Step 2: Find User\n";
$userModel = new User();
$user = $userModel->findByLogin($login);

if (!$user) {
    echo "❌ User not found\n";
    exit;
}

echo "✅ User found:\n";
echo "  ID: " . $user['id'] . "\n";
echo "  Username: " . $user['username'] . "\n";
echo "  Email: " . $user['email'] . "\n";
echo "  Active: " . ($user['active'] ? 'Yes' : 'No') . "\n";
echo "  Role: " . $user['role'] . "\n";
echo "  Password Hash: " . substr($user['password'], 0, 30) . "...\n\n";

// Step 3: Check active status
echo "Step 3: Check Active Status\n";
$isActive = (int)$user['active'];
echo "Active value: $isActive\n";

if (!$isActive) {
    echo "❌ User is inactive\n";
    exit;
}
echo "✅ User is active\n\n";

// Step 4: Verify password
echo "Step 4: Password Verification\n";
$passwordValid = password_verify($password, $user['password']);
echo "Password verification result: " . ($passwordValid ? 'true' : 'false') . "\n";

if (!$passwordValid) {
    echo "❌ Password verification failed\n";
    echo "Trying to verify with different methods:\n";
    
    // Try different password verification methods
    echo "  - password_verify(): " . (password_verify($password, $user['password']) ? 'true' : 'false') . "\n";
    echo "  - hash_equals(): " . (hash_equals($user['password'], password_hash($password, PASSWORD_DEFAULT)) ? 'true' : 'false') . "\n";
    
    // Check if it's a different hash type
    if (strpos($user['password'], '$2y$') === 0) {
        echo "  - Hash appears to be bcrypt\n";
    } else {
        echo "  - Hash does not appear to be bcrypt\n";
    }
    
    exit;
}
echo "✅ Password verification successful\n\n";

// Step 5: Set session
echo "Step 5: Set Session\n";
$_SESSION['uid'] = (int)$user['id'];
$_SESSION['uname'] = $user['username'];
$_SESSION['role'] = $user['role'];

echo "Session data set:\n";
echo "  uid: " . $_SESSION['uid'] . "\n";
echo "  uname: " . $_SESSION['uname'] . "\n";
echo "  role: " . $_SESSION['role'] . "\n\n";

// Step 6: Update last login
echo "Step 6: Update Last Login\n";
$updateResult = $userModel->updateLastLogin($user['id']);
echo "Last login update: " . ($updateResult ? 'Success' : 'Failed') . "\n\n";

echo "✅ Login process completed successfully!\n";
echo "You should be able to log in with admin/password\n";
?>
