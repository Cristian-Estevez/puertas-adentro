# Architecture and LAMP Serving Guide

This document explains how the Puertas Adentro PHP application works with the LAMP (Linux, Apache, MySQL, PHP) stack and how files in the `public/` directory serve as entry points.

## 🌐 LAMP Stack Overview

```
┌─────────────────────────────────────────────────────────────┐
│                    LAMP Stack Layers                        │
├─────────────────────────────────────────────────────────────┤
│  Linux (OS)                                                 │
│  ├── Apache (Web Server) - Document Root: /public/          │
│  ├── MySQL (Database) - Data Storage                        │
│  └── PHP (Server-side Language) - Application Logic         │
└─────────────────────────────────────────────────────────────┘
```

## 📁 Document Root Configuration

In LAMP, Apache's document root is set to the `public/` directory:

```apache
# Apache Virtual Host Configuration
<VirtualHost *:80>
    DocumentRoot /path/to/puertas-adentro/public
    ServerName your-domain.com
    
    # Security: Prevent access to app/ directory
    <Directory "/path/to/puertas-adentro/app">
        Require all denied
    </Directory>
    
    # Allow access only to public/ directory
    <Directory "/path/to/puertas-adentro/public">
        Require all granted
        DirectoryIndex index.php
    </Directory>
</VirtualHost>
```

## 🚪 How Public Files Work

### Entry Points (Public Files)

Each file in `public/` serves as an **entry point** that:

1. **Receives HTTP requests** from the browser
2. **Bootstraps the application** (loads config, starts sessions)
3. **Routes to appropriate controllers**
4. **Returns HTTP responses**

### Request Flow

```
Browser Request → Apache → PHP → Public File → Controller → View → Response
```

## 📄 Detailed File Analysis

### `public/index.php` - Main Entry Point

```php
// Current implementation (basic)
require_once dirname(__DIR__) . '/config/env.php';
// ... environment setup ...
echo "Hello, PHP World!";
```

**How it works:**
1. **Apache receives** `GET /` request
2. **Apache serves** `public/index.php` (DirectoryIndex)
3. **PHP executes** the file
4. **Loads environment** configuration
5. **Returns response** to browser

### `public/login.php` - Authentication Entry Point

```php
// Current implementation
require_once dirname(__DIR__) . '/config/env.php';
require_once dirname(__DIR__) . '/app/controllers/LoginController.php';

$controller = new LoginController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->authenticate();  // Handle form submission
} else {
    $controller->showLoginForm(); // Show login form
}
```

**How it works:**
1. **Browser requests** `GET /login.php` or `POST /login.php`
2. **Apache serves** `public/login.php`
3. **PHP loads** environment and controller
4. **Controller handles** request (show form or authenticate)
5. **View renders** HTML response

### `public/logout.php` - Logout Handler

```php
// Current implementation
require_once dirname(__DIR__) . '/app/controllers/LoginController.php';

$controller = new LoginController();
$controller->logout(); // Destroy session and redirect
```

## 🔄 LAMP Request Processing Flow

```
┌─────────────────────────────────────────────────────────────┐
│                    LAMP Request Flow                        │
└─────────────────────────────────────────────────────────────┘

1. Browser Request
   ↓
   GET /login.php HTTP/1.1
   Host: your-domain.com

2. Apache Web Server
   ↓
   - Receives request
   - Maps URL to file system
   - Serves: /public/login.php

3. PHP Engine
   ↓
   - Parses PHP code
   - Executes: require_once, new LoginController()
   - Processes: $_SERVER, $_POST, $_SESSION

4. Application Layer
   ↓
   - LoginController::showLoginForm()
   - View::renderWithLayout('auth/login', 'main')
   - Template engine processes views

5. Database (if needed)
   ↓
   - MySQL queries via PDO
   - User authentication data

6. Response Generation
   ↓
   - HTML content rendered
   - Headers set (Content-Type, Location)
   - Session data updated

7. Apache Response
   ↓
   HTTP/1.1 200 OK
   Content-Type: text/html; charset=UTF-8
   <!DOCTYPE html>...

8. Browser
   ↓
   - Receives HTML
   - Renders page
   - User sees login form
```

## 🔒 Security Architecture

### Directory Protection

```
puertas-adentro/
├── public/          ← Apache Document Root (ACCESSIBLE)
│   ├── index.php
│   ├── login.php
│   └── logout.php
├── app/             ← PROTECTED (Apache blocks access)
│   ├── classes/
│   ├── controllers/
│   ├── models/
│   └── views/
├── config/          ← PROTECTED
└── migrations/      ← PROTECTED
```

### Apache Configuration for Security

```apache
# Deny access to sensitive directories
<Directory "/path/to/puertas-adentro/app">
    Require all denied
</Directory>

<Directory "/path/to/puertas-adentro/config">
    Require all denied
</Directory>

<Directory "/path/to/puertas-adentro/migrations">
    Require all denied
</Directory>
```

## 🌐 URL Routing Examples

| URL | Apache Serves | PHP Executes | Result |
|-----|---------------|--------------|---------|
| `http://domain.com/` | `public/index.php` | Environment setup | Welcome page |
| `http://domain.com/login.php` | `public/login.php` | LoginController | Login form |
| `http://domain.com/logout.php` | `public/logout.php` | LoginController::logout() | Redirect to login |
| `http://domain.com/app/classes/` | **403 Forbidden** | - | Security block |

## ⚙️ Environment Configuration

The `config/env.php` file is loaded by all public files:

```php
// config/env.php
define('ENV', $_ENV['ENVIRONMENT'] ?? 'development');
define('DB_HOST', $_ENV['DB_HOST'] ?? 'localhost');
define('DB_NAME', $_ENV['DB_NAME'] ?? 'puertas_adentro');
// ... more configuration
```

## 🔐 Session Management

Sessions are started in public files and persist across requests:

```php
// In public/login.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Session data available in controllers
$_SESSION['uid'] = $user['id'];
$_SESSION['uname'] = $user['username'];
```

## 🗄️ Database Connection

Database connections are established through the Model class:

```php
// app/classes/Database.php
class Database {
    private static $instance = null;
    private $connection;
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}
```

## 🔄 Complete Request Example

**User visits `http://your-domain.com/login.php`:**

1. **Browser** → Apache: `GET /login.php`
2. **Apache** → PHP: Execute `public/login.php`
3. **PHP** → Load: `config/env.php` + `LoginController.php`
4. **PHP** → Create: `new LoginController()`
5. **Controller** → View: `$this->view->renderWithLayout('auth/login')`
6. **View** → Template: Process `views/auth/login.php` + `views/layouts/main.php`
7. **Template** → HTML: Generate complete HTML page
8. **PHP** → Apache: Return HTML response
9. **Apache** → Browser: `HTTP 200 OK` + HTML content
10. **Browser** → User: Display login form

## 🎯 Benefits of This Architecture

- **Security**: Only `public/` is web-accessible
- **Organization**: Clear separation of concerns
- **Maintainability**: Easy to add new entry points
- **Scalability**: Can add load balancers, caching
- **Standards**: Follows PHP-FIG and PSR standards

## 🚀 Adding New Entry Points

To add a new page to your application:

1. **Create a new file** in `public/` (e.g., `public/dashboard.php`)
2. **Bootstrap the application** (load config, start session)
3. **Instantiate the appropriate controller**
4. **Handle the request** (GET/POST logic)
5. **Return the response** (HTML via views)

Example:
```php
<?php
// public/dashboard.php
require_once dirname(__DIR__) . '/config/env.php';
require_once dirname(__DIR__) . '/app/controllers/DashboardController.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$controller = new DashboardController();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $controller->showDashboard();
} else {
    $controller->handlePost();
}
```

## 🔧 LAMP Setup Requirements

### Apache Configuration
- Document root set to `public/` directory
- PHP module enabled
- URL rewriting enabled (for clean URLs)
- Security headers configured

### PHP Configuration
- PHP 7.4+ recommended
- PDO MySQL extension enabled
- Session support enabled
- Error reporting configured per environment

### MySQL Configuration
- Database created and configured
- User permissions set
- Connection parameters in environment config

### Linux File Permissions
```bash
# Set proper permissions
chmod 755 /path/to/puertas-adentro/
chmod 644 /path/to/puertas-adentro/public/*
chmod 600 /path/to/puertas-adentro/config/env.php
```

This architecture ensures that your application is secure, maintainable, and follows modern PHP development best practices! 🚀
