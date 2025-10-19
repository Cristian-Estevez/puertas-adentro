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

/** Escapa texto para imprimir en HTML y prevenir XSS */
function e(string $s): string {
    return htmlspecialchars($s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/** Inicia la sesión con opciones básicas de seguridad */
function start_secure_session(array $cfg = []): void {
    $secure = !empty($cfg['https']);                 // en XAMPP normalmente false (http)
    $name   = $cfg['session_name']    ?? 'app_sess';
    $ttl    = (int)($cfg['session_timeout'] ?? 1800); // 30 minutos

    if (session_status() === PHP_SESSION_NONE) {
        session_name($name);
        session_set_cookie_params([
            'lifetime' => 0,        // hasta cerrar navegador
            'path'     => '/',
            'secure'   => $secure,  // true solo con HTTPS real
            'httponly' => true,     // JS no puede leer la cookie (mitiga XSS)
            'samesite' => 'Lax',    // reduce CSRF básico
        ]);
        session_start();
    }

    // Rotar ID cada 5 minutos (anti session fixation)
    if (!isset($_SESSION['created'])) $_SESSION['created'] = time();
    if (time() - $_SESSION['created'] > 300) {
        session_regenerate_id(true);
        $_SESSION['created'] = time();
    }

    // Timeout por inactividad
    if (isset($_SESSION['last_activity']) && time() - $_SESSION['last_activity'] > $ttl) {
        session_unset();
        session_destroy();
        header('Location: /login.php?expired=1');
        exit;
    }
    $_SESSION['last_activity'] = time();
}

/** Genera/recupera token CSRF para incluir en formularios */
function csrf_token(): string {
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}

/** Verifica token CSRF recibido por POST contra el guardado en sesión */
function csrf_check(?string $t): bool {
    return isset($_SESSION['csrf']) && hash_equals($_SESSION['csrf'], $t ?? '');
}

/** Validación/sanitización simple para el login */
function validate_login_input($login, $password, array &$errors): array {
    $login = trim((string)$login);
    $password = (string)$password;

    if ($login === '')    $errors[] = 'El usuario o email es obligatorio.';
    if ($password === '') $errors[] = 'La contraseña es obligatoria.';
    if (strlen($password) > 4096) $errors[] = 'La contraseña es inválida.';
    if (strpos($login, '@') !== false && !filter_var($login, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'El formato de email es inválido.';
    }
    return [$login, $password];
}

// Global User instance for utility functions
$userModel = new User();

// ------------------------------------------------------------
// validate_username($u)
// Valida un nombre de usuario a nivel de formato.
// Devuelve NULL si es válido, o un string con el motivo del error.
// Reglas:
//   - 3 a 32 caracteres
//   - Solo letras, números, punto, guion y guion bajo (evita espacios y símbolos raros)
// ------------------------------------------------------------
function validate_username(string $u): ?string {
    $u = trim($u);
    if ($u === '' || strlen($u) < 3 || strlen($u) > 32) {
        return 'El usuario debe tener entre 3 y 32 caracteres.';
    }
    if (!preg_match('/^[A-Za-z0-9][A-Za-z0-9._-]*[A-Za-z0-9]$|^[A-Za-z0-9]$/', $u)) {
        return 'El usuario solo puede tener letras, números, punto, guion y guion bajo. Debe empezar y terminar con letra o número.';
    }
    if (username_exists($u)) {
        return 'El nombre de usuario ya esta en uso.';
    }
    return null; // OK
}


// ------------------------------------------------------------
// validate_password($p, $p2)
// Valida la contraseña y su confirmación.
// Devuelve NULL si ambas son válidas y coinciden; de lo contrario, texto de error.
// Reglas mínimas:
//   - longitud >= 6 (para el proyecto local es suficiente)
//   - $p y $p2 deben ser iguales
// ------------------------------------------------------------
function validate_password(string $p, string $p2): ?string {
    if (strlen($p) < 6) {
        return 'La contraseña debe tener al menos 6 caracteres.';
    }
    if ($p !== $p2) {
        return 'Las contraseñas no coinciden.';
    }
    return null; // OK
}


// ------------------------------------------------------------
// validate_email($email)
// Valida un email (obligatorio).
// Devuelve NULL si es válido; si es inválido o vacío, devuelve un texto de error.
// ------------------------------------------------------------
function validate_email(string $email): ?string {
    $email = trim($email);
    if ($email === '') {
        return 'El email es obligatorio.';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return 'Email inválido.';
    }
    return null; // OK
}


// ------------------------------------------------------------
// username_exists($u)
// Verifica si ya existe un usuario con ese username (UNIQUE).
// Devuelve true si existe; false si no.
// Seguridad: usa consulta preparada para evitar SQLi.
// Rendimiento: LIMIT 1 para cortar al primer match.
// ------------------------------------------------------------
function username_exists(string $u): bool {
    global $userModel;
    return $userModel->findByUsername($u) !== null;
}


// ------------------------------------------------------------
// email_exists($email)
// Verifica si ya existe un usuario con ese email (UNIQUE).
// Devuelve true si existe; false si no.
// ------------------------------------------------------------
function email_exists(string $email): bool {
    global $userModel;
    return $userModel->findByEmail($email) !== null;
}


// ------------------------------------------------------------
// register_user($username, $email, $password, $password2)
// Crea un nuevo usuario con role 'user' si pasa todas las validaciones.
// Flujo:
//   1) Valida formato de username, email obligatorio y password.
//   2) Chequea unicidad de username y email.
//   3) Hashea la contraseña con password_hash (bcrypt).
//   4) Inserta el registro en la tabla `users` con role 'user' y display_name = username.
// Devuelve:
//   - ['ok' => true] si se registró correctamente
//   - ['ok' => false, 'errors' => [...]] con el listado de errores si falló
// Notas:
//   - No hace login automático; podés hacerlo aparte si querés.
//   - Email es obligatorio.
// ------------------------------------------------------------
function register_user(string $username, string $email, string $password, string $password2): array {
    $errors = [];

    // Validaciones de formato
    if ($e = validate_username($username))              $errors[] = $e;
    if ($e = validate_email($email))                    $errors[] = $e;
    if ($e = validate_password($password, $password2))  $errors[] = $e;

    // Unicidad en DB
    if (!$errors && username_exists($username)) $errors[] = 'El usuario ya existe.';
    if (!$errors && email_exists($email))       $errors[] = 'El email ya está en uso.';

    if ($errors) {
        return ['ok' => false, 'errors' => $errors];
    }

    // Hasheo de contraseña (bcrypt por defecto)
    $hash    = password_hash($password, PASSWORD_BCRYPT);
    $display = $username; // MVP: display_name = username

    // Insert seguro con parámetros
    global $userModel;
    $userModel->create([
        'username'      => $username,
        'email'         => $email,
        'password_hash' => $hash,
        'role'          => 'user',
        'display_name'  => $display,
    ]);

    return ['ok' => true];
}


// ------------------------------------------------------------
// login_user($login, $password)
// Inicia sesión si las credenciales son correctas.
// Acepta que $login sea username O email (flexible).
// Flujo:
//   1) Busca el registro por username/email (consulta preparada).
//   2) Verifica que el usuario esté activo (is_active = 1).
//   3) Verifica la contraseña con password_verify.
//   4) Guarda en $_SESSION los datos mínimos (id, username, role).
//   5) Actualiza last_login_at para auditoría básica.
//   + Regenera el ID de sesión (anti fixation).
// Devuelve true si inició correctamente; false si credenciales inválidas o usuario inactivo.
// ------------------------------------------------------------
function login_user(string $login, string $password): bool {
    global $userModel;

    $u = $userModel->findByLogin($login);
    if (!$u) return false;

    // Compatibilidad: algunas DB usan 'is_active', otras 'active'
    $isActive = isset($u['is_active']) ? (int)$u['is_active'] : ((int)($u['active'] ?? 1));
    if ($isActive !== 1) return false;

    // Compatibilidad: 'password_hash' o 'password'
    $hash = $u['password_hash'] ?? ($u['password'] ?? null);
    if (!$hash || !password_verify($password, $hash)) return false;

    // Regenerar ID (anti fixation) y guardar mínimos en sesión
    if (session_status() === PHP_SESSION_ACTIVE) {
        session_regenerate_id(true);
    }
    $_SESSION['uid']    = (int)$u['id'];
    $_SESSION['uname']  = $u['username'];
    $_SESSION['role']   = $u['role'];

    // Rotar CSRF al iniciar sesión (opcional)
    unset($_SESSION['csrf']);

    // Auditoría básica
    $userModel->updateLastLogin($u['id']);

    return true;
}


// ------------------------------------------------------------
// logout_user()
// Cierra la sesión de manera segura.
// ------------------------------------------------------------
function logout_user(): void {
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $p = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $p['path'],
            $p['domain'],
            $p['secure'],
            true // forzamos httponly
        );
    }
    session_destroy();
}


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
