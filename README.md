# Project Structure

This project follows a modern PHP web application structure:

- `public/` — Web root. Contains `index.php` (front controller) and all publicly accessible assets (CSS, JS, images). Set as the document root in your web server.
- `src/` — Core application source code (PHP classes, functions). Organize by type (Controller/, Model/, Service/) or feature (User/, Order/).
- `config/` — Application configuration files (database, environment, framework configs).
- `var/` — Temporary files (cache, logs, uploads). Ignored by VCS.
- `bin/` — Command-line scripts and tools.

## Root Files
- `.env` — Environment-specific variables.
- `.gitignore` — Git ignore rules.
- `README.md` — Project documentation.

This structure is recommended for clarity, security, and maintainability. The `public/` directory is the only web-exposed directory. Source code is organized for PSR-4 autoloading and PHP-FIG standards.
