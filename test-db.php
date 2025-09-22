<?php
/**
 * Database Connection Test
 * 
 * This script tests the database connection and user lookup
 * in the same way the web application does it.
 */

require_once 'config/env.php';
require_once 'app/classes/Database.php';
require_once 'app/models/User.php';

echo "=== Database Connection Test ===\n\n";

try {
    // Test database connection
    echo "1. Testing database connection...\n";
    $db = Database::getInstance()->getConnection();
    echo "✅ Database connection successful\n\n";
    
    // Test user model
    echo "2. Testing User model...\n";
    $userModel = new User();
    echo "✅ User model created successfully\n\n";
    
    // Test user lookup
    echo "3. Testing user lookup...\n";
    $user = $userModel->findByLogin('admin');
    
    if ($user) {
        echo "✅ User found:\n";
        echo "   ID: " . $user['id'] . "\n";
        echo "   Username: " . $user['username'] . "\n";
        echo "   Email: " . $user['email'] . "\n";
        echo "   Active: " . ($user['active'] ? 'Yes' : 'No') . "\n";
        echo "   Role: " . $user['role'] . "\n";
        echo "   Password Hash: " . substr($user['password'], 0, 30) . "...\n\n";
        
        // Test password verification
        echo "4. Testing password verification...\n";
        $password = 'password';
        $isValid = password_verify($password, $user['password']);
        echo "Password 'password' verification: " . ($isValid ? '✅ Valid' : '❌ Invalid') . "\n\n";
        
        // Test the exact condition from LoginController
        echo "5. Testing LoginController condition...\n";
        $condition1 = !$user;
        $condition2 = !(int)$user['active'];
        $condition3 = !password_verify($password, $user['password']);
        
        echo "   !user: " . ($condition1 ? 'true' : 'false') . "\n";
        echo "   !(int)user['active']: " . ($condition2 ? 'true' : 'false') . "\n";
        echo "   !password_verify(): " . ($condition3 ? 'true' : 'false') . "\n";
        
        $shouldFail = $condition1 || $condition2 || $condition3;
        echo "   Should fail authentication: " . ($shouldFail ? '❌ YES' : '✅ NO') . "\n\n";
        
        if (!$shouldFail) {
            echo "✅ All tests passed! Login should work.\n";
        } else {
            echo "❌ One or more conditions failed. This explains the login issue.\n";
        }
        
    } else {
        echo "❌ User not found\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}
?>
