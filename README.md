# Puertas Adentro - PHP MVC Application

A modern PHP web application built with MVC architecture, featuring a custom view system and clean separation of concerns.

📝 **[Click here to view the XAMPP/LAMP Setup Guide](documentation/SETUP-GUIDE.md)** - Step by step instructions to get the project running.

## Project Structure

```
puertas-adentro/
├── app/                          # Application source code
│   ├── classes/                  # Core classes and utilities
│   │   ├── Database.php         # Database connection singleton
│   │   ├── Model.php            # Base model class
│   │   └── View.php             # Template engine
│   ├── controllers/              # Application controllers
│   │   ├── LoginController.php  # Authentication controller
│   │   └── ExampleController.php # Example usage
│   ├── models/                   # Data models
│   │   └── User.php             # User model
│   ├── utils/                    # Utility functions
│   │   └── login-utils.php      # Login helper functions
│   └── views/                    # Template files
│       ├── layouts/              # Layout templates
│       │   └── main.php         # Main layout wrapper
│       ├── auth/                 # Authentication views
│       │   └── login.php        # Login form template
│       ├── partials/             # Reusable components
│       │   └── alert.php        # Alert component
│       └── dashboard.php         # Dashboard view
├── public/                       # Web root (document root)
│   ├── index.php                # Front controller
│   ├── login.php                # Login page entry point
│   └── logout.php               # Logout handler
├── config/                       # Configuration files
│   └── env.php                  # Environment configuration
├── migrations/                   # Database migrations
│   └── init-db-script.sql       # Initial database setup
├── var/                         # Temporary files (logs, cache)
├── bin/                         # Command-line scripts
├── vendor/                      # Composer dependencies
└── README.md                    # This file
```

## Architecture Overview

### MVC Pattern Implementation

- **Models** (`app/models/`) - Handle data logic and database interactions
- **Views** (`app/views/`) - Template files for HTML output
- **Controllers** (`app/controllers/`) - Handle HTTP requests and coordinate between models and views

### View System

The application includes a custom template engine (`app/classes/View.php`) that provides:

- **Template Rendering** - Clean separation of HTML and PHP logic
- **Layout System** - Reusable layout templates with content injection
- **Data Passing** - Secure data passing to templates
- **XSS Protection** - Built-in HTML escaping
- **URL Generation** - Helper methods for creating application URLs
- **Component System** - Reusable partial templates

### Key Features

- **Security First** - Input validation, XSS protection, prepared statements
- **PSR Standards** - Follows PHP-FIG standards for autoloading and coding style
- **Clean Architecture** - SOLID principles and separation of concerns
- **Environment Configuration** - Development/production environment handling
- **Session Management** - Secure user authentication and session handling

## Usage Examples

### Creating a New Controller

```php
<?php
require_once dirname(__DIR__) . '/classes/View.php';

class YourController {
    private $view;
    
    public function __construct() {
        $this->view = new View();
    }
    
    public function showPage(): void {
        $content = $this->view
            ->with('title', 'Page Title')
            ->with('data', $someData)
            ->renderWithLayout('your-template', 'main');
        
        echo $content;
    }
}
```

### Creating a New View Template

```php
<!-- app/views/your-template.php -->
<div class="card">
    <h1><?= $this->escape($title) ?></h1>
    <p><?= $this->escape($data['description']) ?></p>
</div>
```

### View System Methods

- `with($key, $value)` - Set single data value
- `withData($array)` - Set multiple data at once
- `render($template)` - Render template without layout
- `renderWithLayout($template, $layout)` - Render with layout wrapper
- `escape($string)` - Escape HTML output
- `url($path)` - Generate application URLs

## Security Features

- Input validation and sanitization
- SQL injection prevention with prepared statements
- XSS protection with HTML escaping
- Secure session management
- Environment-based configuration
- CSRF protection ready

## Development Setup

1. Set document root to `public/` directory
2. Configure environment variables in `config/env.php`
3. Run database migrations from `migrations/` directory
4. Install dependencies with Composer (if applicable)

## File Organization

- **`public/`** - Only web-exposed directory, contains entry points
- **`app/`** - All application logic organized by MVC pattern
- **`config/`** - Environment and application configuration
- **`migrations/`** - Database schema and data migrations
- **`var/`** - Temporary files, logs, and cache (VCS ignored)
- **`bin/`** - Command-line tools and scripts

This structure ensures security, maintainability, and follows modern PHP development best practices.
