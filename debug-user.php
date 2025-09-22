<?php
/**
 * Debug User Data Script
 * 
 * This script helps debug user authentication issues
 * by showing what's in the database.
 */

require_once 'config/env.php';
require_once 'app/classes/Database.php';

try {
    $db = Database::getInstance()->getConnection();
    
    echo "=== User Debug Information ===\n\n";
    
    // Get all users
    $stmt = $db->query("SELECT id, username, email, active, role, password FROM users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($users)) {
        echo "❌ No users found in database!\n";
        exit(1);
    }
    
    echo "Found " . count($users) . " user(s):\n\n";
    
    foreach ($users as $user) {
        echo "ID: " . $user['id'] . "\n";
        echo "Username: " . $user['username'] . "\n";
        echo "Email: " . $user['email'] . "\n";
        echo "Active: " . ($user['active'] ? 'Yes' : 'No') . "\n";
        echo "Role: " . $user['role'] . "\n";
        echo "Password Hash: " . substr($user['password'], 0, 20) . "...\n";
        echo "---\n";
    }
    
    // Test password verification
    echo "\n=== Password Verification Test ===\n";
    $testPassword = 'password';
    
    foreach ($users as $user) {
        $isValid = password_verify($testPassword, $user['password']);
        echo "User '{$user['username']}': " . ($isValid ? '✅ Valid' : '❌ Invalid') . "\n";
    }
    
    echo "\n=== Login Test ===\n";
    $testLogin = 'admin';
    $stmt = $db->prepare("SELECT * FROM users WHERE username = :login OR email = :login LIMIT 1");
    $stmt->execute(['login' => $testLogin]);
    $foundUser = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($foundUser) {
        echo "✅ User found: " . $foundUser['username'] . "\n";
        echo "Active status: " . ($foundUser['active'] ? 'Active' : 'Inactive') . "\n";
        echo "Password verification: " . (password_verify($testPassword, $foundUser['password']) ? '✅ Valid' : '❌ Invalid') . "\n";
    } else {
        echo "❌ User not found for login: $testLogin\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>
