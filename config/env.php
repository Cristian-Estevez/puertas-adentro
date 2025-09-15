<?php
// config/env.php
// Environment configuration loader

declare(strict_types=1);

/**
 * Load environment variables from .env file
 */
function loadEnv(?string $envFile = null): void
{
    $envFile = $envFile ?? dirname(__DIR__) . '/.env';
    
    if (!file_exists($envFile)) {
        return;
    }
    
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    
    foreach ($lines as $line) {
        if (strpos($line, '#') === 0) {
            continue; // Skip comments
        }
        
        if (strpos($line, '=') !== false) {
            list($key, $value) = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value);
            
            // Remove quotes if present
            if (preg_match('/^(["\'])(.*)\1$/', $value, $matches)) {
                $value = $matches[2];
            }
            
            if (!array_key_exists($key, $_ENV)) {
                $_ENV[$key] = $value;
                putenv("$key=$value");
            }
        }
    }
}

/**
 * Get environment variable
 */
function env(string $key, mixed $default = null): mixed
{
    return $_ENV[$key] ?? getenv($key) ?: $default;
}

// Load environment variables when this file is included
loadEnv();

// Define ENV constant for easy access
if (!defined('ENV')) {
    define('ENV', env('ENVIRONMENT', 'development'));
}
