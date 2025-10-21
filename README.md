# Puertas Adentro - PHP MVC Application

A modern PHP web application built with MVC architecture, featuring a custom view system and clean separation of concerns.

## 🚀 Quick Setup Guide

### Prerequisites

- **XAMPP** (Windows/Mac) or **LAMP** (Linux) installed
- **Apache 2.4+**
- **PHP 7.4+ or 8.0+**
- **MySQL 5.7+ or MariaDB 10.4+**

---

## 📋 Windows Setup (XAMPP)

### Step 1: Install XAMPP
1. Download XAMPP from [https://www.apachefriends.org/](https://www.apachefriends.org/)
2. Install XAMPP in `C:\xampp\` (default location)
3. Start XAMPP Control Panel as Administrator

### Step 2: Project Setup
1. **Clone/Download** the project to: `C:\xampp\htdocs\puertas-adentro\`
2. **Set Document Root** in XAMPP:
   - Open XAMPP Control Panel
   - Click "Config" next to Apache → "Apache (httpd.conf)"
   - Find and modify these lines:
   ```apache
   DocumentRoot "C:/xampp/htdocs/puertas-adentro/public"
   <Directory "C:/xampp/htdocs/puertas-adentro/public">
       AllowOverride All
       Require all granted
   </Directory>
   ```
3. **Restart Apache** after making changes

### Step 3: Database Setup
1. **Start Services** in XAMPP Control Panel:
   - ✅ Start **Apache**
   - ✅ Start **MySQL**

2. **Create Database**:
   - Open browser → `http://localhost/phpmyadmin`
   - Click "New" → Create database: `puertas_adentro`
   - Click "Create"

3. **Import Database Schema**:
   - Select `puertas_adentro` database
   - Click "Import" tab
   - Choose file: `C:\xampp\htdocs\puertas-adentro\migrations\init-db-script.sql`
   - Click "Go" to execute

4. **Verify Import**:
   - You should see tables: `users`, `posts`, `comments`, `likes`
   - Check that sample data is loaded (7 users, 8 posts, etc.)

### Step 4: Environment Configuration
1. **Create `.env` file** in project root (`C:\xampp\htdocs\puertas-adentro\.env`):
   ```env
   ENVIRONMENT=development
   DB_HOST=localhost
   DB_NAME=puertas_adentro
   DB_USER=root
   DB_PASS=
   ```

2. **Verify Configuration** in `config/env.php` (should already exist)

### Step 5: Access Application
- **Main Application**: `http://localhost`
- **Test Credentials**:
  - Admin: `admin@ejemplo.com` / `password`
  - User: `santiago@ejemplo.com` / `password`

---

## 🐧 Linux Setup (XAMPP/LAMPP)

### Step 1: Install XAMPP/LAMPP
1. **Download XAMPP for Linux** from [https://www.apachefriends.org/](https://www.apachefriends.org/)
2. **Install XAMPP**:
   ```bash
   # Make installer executable
   chmod +x xampp-linux-x64-*-installer.run
   
   # Run installer
   sudo ./xampp-linux-x64-*-installer.run
   ```
3. **Start XAMPP/LAMPP**:
   ```bash
   sudo /opt/lampp/lampp start
   ```

### Step 2: Project Setup
1. **Copy Project** to XAMPP htdocs directory:
   ```bash
   # Copy project to htdocs
   sudo cp -r /path/to/puertas-adentro /opt/lampp/htdocs/
   
   # Set proper permissions
   sudo chown -R www-data:www-data /opt/lampp/htdocs/puertas-adentro
   sudo chmod -R 755 /opt/lampp/htdocs/puertas-adentro
   sudo find /opt/lampp/htdocs/puertas-adentro -name "*.php" -exec chmod 755 {} \;
   ```

2. **Configure Document Root** (Optional - for cleaner URLs):
   Edit `/opt/lampp/etc/httpd.conf`:
   ```apache
   DocumentRoot "/opt/lampp/htdocs/puertas-adentro/public"
   <Directory "/opt/lampp/htdocs/puertas-adentro/public">
       AllowOverride All
       Require all granted
   </Directory>
   ```

3. **Restart LAMPP** after configuration changes:
   ```bash
   sudo /opt/lampp/lampp restart
   ```

### Step 3: Database Setup
1. **Start LAMPP Services**:
   ```bash
   sudo /opt/lampp/lampp start
   ```

2. **Access phpMyAdmin**:
   - Open browser → `http://localhost/phpmyadmin`
   - Create database: `puertas_adentro`

3. **Import Database Schema**:
   - Select `puertas_adentro` database
   - Click "Import" tab
   - Choose file: `/opt/lampp/htdocs/puertas-adentro/migrations/init-db-script.sql`
   - Click "Import" to execute

4. **Alternative: Command Line Import** (requires database to exist first):
   ```bash
   # First create the database (if not done via UI)
   /opt/lampp/bin/mysql -u root -p -e "CREATE DATABASE IF NOT EXISTS puertas_adentro;"
   
   # Then import the schema
   /opt/lampp/bin/mysql -u root -p puertas_adentro < /opt/lampp/htdocs/puertas-adentro/migrations/init-db-script.sql
   ```

### Step 4: Environment Configuration
1. **Verify `.env` file exists** (already included in project):
   ```bash
   ls -la /opt/lampp/htdocs/puertas-adentro/.env
   ```

2. **Set Permissions**:
   ```bash
   sudo chmod 644 /opt/lampp/htdocs/puertas-adentro/.env
   ```

3. **Optional: Edit if needed**:
   ```bash
   nano /opt/lampp/htdocs/puertas-adentro/.env
   ```
   The default configuration should work for development:
   ```env
   ENVIRONMENT=development
   DB_HOST=localhost
   DB_NAME=puertas_adentro
   DB_USER=root
   DB_PASS=
   ```

### Step 5: Access Application
- **Application**: `http://localhost`
- **Test Credentials**:
  - Admin: `admin@ejemplo.com` / `password`
  - User: `santiago@ejemplo.com` / `password`


### Step 6: Development Workflow (Optional)
For easier development, you can create a deployment script:

```bash
#!/bin/bash
# deploy.sh - Quick deployment script for development

PROJECT_SOURCE="/path/to/your/source/puertas-adentro"
HTDOCS_TARGET="/opt/lampp/htdocs/puertas-adentro"

echo "🚀 Deploying project..."

# Stop LAMPP
sudo /opt/lampp/lampp stop

# Remove existing project
sudo rm -rf "$HTDOCS_TARGET"

# Copy project
sudo cp -r "$PROJECT_SOURCE" "$HTDOCS_TARGET"

# Set permissions
sudo chown -R www-data:www-data "$HTDOCS_TARGET"
sudo chmod -R 755 "$HTDOCS_TARGET"
sudo find "$HTDOCS_TARGET" -name "*.php" -exec chmod 755 {} \;

# Restart LAMPP
sudo /opt/lampp/lampp restart

echo "✅ Deployment completed!"
echo "🌐 Project available at: http://localhost"
```

---

## 🔧 Troubleshooting

### Common Issues & Solutions

#### 1. **White Screen / 500 Error**
```bash
# Check Apache error logs
sudo tail -f /var/log/apache2/error.log

# Check PHP error logs
sudo tail -f /var/log/php_errors.log
```

**Solutions**:
- Verify file permissions
- Check database connection in `config/env.php`
- Ensure all required PHP extensions are installed

#### 2. **Database Connection Failed**
```bash
# Test MySQL connection
mysql -u puertas_user -p -e "SHOW DATABASES;"

# Check if database exists
mysql -u puertas_user -p -e "USE puertas_adentro; SHOW TABLES;"
```

**Solutions**:
- Verify MySQL service is running
- Check credentials in `.env` file
- Ensure database was imported correctly

#### 3. **404 Not Found**
**Solutions**:
- Verify Apache rewrite module is enabled: `sudo a2enmod rewrite`
- Check virtual host configuration
- Ensure you're accessing through the `public` directory

#### 4. **Permission Denied**
```bash
# Fix ownership and permissions
sudo chown -R www-data:www-data /opt/lampp/htdocs/puertas-adentro
sudo chmod -R 755 /opt/lampp/htdocs/puertas-adentro
sudo chmod 644 /opt/lampp/htdocs/puertas-adentro/.env
```

### Verification Steps

1. **Check Services**:
   ```bash
   # Linux
   sudo systemctl status apache2
   sudo systemctl status mysql
   
   # Windows - Check XAMPP Control Panel
   ```

2. **Test Database Connection**:
   ```bash
   mysql -u puertas_user -p puertas_adentro -e "SELECT COUNT(*) FROM users;"
   ```

3. **Verify Application**:
   - Visit `http://localhost/`
   - Try logging in with test credentials
   - Check that posts and comments are displayed

---

## 🔐 Default Test Accounts

After successful database import, you can use these accounts:

| Role | Email | Username | Password |
|------|-------|----------|----------|
| Admin | admin@ejemplo.com | admin | password |
| User | santiago@ejemplo.com | santiago | password |
| User | miguel@ejemplo.com | miguel | password |
| User | sara@ejemplo.com | sara | password |

---

## 🔒 Security & Production Considerations

### Development Environment (Current Setup)
This project uses **default database credentials** for ease of setup and testing purposes:

- **Windows XAMPP**: `root` user with **empty password**
- **Linux LAMP**: Custom user `puertas_user` with configurable password

**⚠️ Important**: These credentials are intended **ONLY for development and testing environments**. They should **NEVER be used in production**.

### Production Environment Requirements
For production deployment, you **MUST** configure a dedicated database user with:

1. **Strong Password**: Use a complex, randomly generated password
2. **Limited Privileges**: Grant only necessary permissions to the application database
3. **Secure Connection**: Use SSL/TLS for database connections
4. **Environment Variables**: Store credentials in secure environment variables, never in code

#### Production Database Setup Example:
```sql
-- Create dedicated production user
CREATE USER 'puertas_prod'@'localhost' IDENTIFIED BY 'your_strong_production_password';

-- Grant only necessary privileges
GRANT SELECT, INSERT, UPDATE, DELETE ON puertas_adentro.* TO 'puertas_prod'@'localhost';

-- Remove any unnecessary privileges
REVOKE ALL PRIVILEGES ON *.* FROM 'puertas_prod'@'localhost';
FLUSH PRIVILEGES;
```

#### Production Environment Configuration:
```env
# .env file for production
ENVIRONMENT=production
DB_HOST=localhost
DB_NAME=puertas_adentro
DB_USER=puertas_prod
DB_PASS=your_strong_production_password
```

### Academic & Research Environment Notes
This application is designed for **university academics and professors** who may be:
- Setting up research projects
- Teaching web development courses
- Conducting academic demonstrations
- Prototyping educational applications

The default credentials facilitate quick setup for these academic purposes while maintaining clear security guidelines for production use.

### Security Best Practices
1. **Never commit** `.env` files to version control
2. **Use different credentials** for development, staging, and production
3. **Regularly rotate** database passwords
4. **Monitor database access** logs
5. **Implement proper backup** strategies
6. **Use HTTPS** in production environments

---

📝 **[Click here to view the detailed XAMPP/LAMP Setup Guide](documentation/SETUP-GUIDE.md)** - Additional setup information and troubleshooting.

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
│   │   └── date-utils.php      # date helper functions
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
