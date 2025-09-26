# Project Setup Guide - XAMPP/LAMP

This guide will help you set up and run the Puertas Adentro project using XAMPP or LAMP stack.

## Prerequisites

- XAMPP (for Windows/Mac) or LAMP (for Linux) installed on your system
  - Apache 2.4+
  - PHP 7.4+ or 8.0+
  - MySQL 5.7+ or MariaDB 10.4+

## Setup Steps

### 1. Server Configuration

1. **For XAMPP users:**
   - Navigate to your XAMPP installation directory
   - Place the project in the `htdocs` folder
   - Path should look like: `/opt/lampp/htdocs/puertas-adentro/` (Linux) or `C:\xampp\htdocs\puertas-adentro\` (Windows)

2. **Set Proper Permissions (Linux only):**
   ```bash
   sudo chown -R www-data:www-data /opt/lampp/htdocs/puertas-adentro
   sudo chmod -R 755 /opt/lampp/htdocs/puertas-adentro
   sudo find /opt/lampp/htdocs/puertas-adentro -name "*.php" -exec chmod 755 {} \;
   sudo chmod 644 /opt/lampp/htdocs/puertas-adentro/config/env.php
   ```

### 2. Database Setup

1. Start Apache and MySQL services:
   - XAMPP Control Panel: Start Apache and MySQL
   - Linux command: `sudo /opt/lampp/lampp start`

2. Open phpMyAdmin (http://localhost/phpmyadmin)
3. Create a new database called `puertas_adentro`
4. Import the database schema:
   - Navigate to the 'Import' tab
   - Select the file from `migrations/init-db-script.sql`
   - Click 'Go' to execute the import

### 3. Project Configuration

1. Navigate to the `config` folder
2. Create `env.php` if it doesn't exist (copy from any example file if available)
3. Configure your database connection:
   ```php
   <?php
   return [
       'DB_HOST' => 'localhost',
       'DB_NAME' => 'puertas_adentro',
       'DB_USER' => 'root', // default XAMPP user
       'DB_PASS' => ''      // default XAMPP password (empty)
   ];
   ```

### 4. Accessing the Application

Access the application through:
- Main page: http://localhost/puertas-adentro/public
- Login page: http://localhost/puertas-adentro/public/login.php

## Troubleshooting

### Common Issues

1. **White Screen / 500 Error**
   - Check PHP error logs in XAMPP/LAMP
   - Verify database connection settings
   - Ensure proper file permissions

2. **Database Connection Failed**
   - Verify MySQL is running
   - Check database credentials in `config/env.php`
   - Ensure database exists and is properly imported

3. **404 Not Found**
   - Verify Apache rewrite module is enabled
   - Check virtual host configuration
   - Ensure you're accessing through the `public` directory

### Getting Help

If you encounter issues not covered here, check:
- Apache error logs (`logs/error.log` in XAMPP/LAMP directory)
- PHP error logs
- MySQL error logs

## Security Notes

- Change default MySQL credentials in production
- Secure the `var` directory from public access
- Remove any development-only configurations in production