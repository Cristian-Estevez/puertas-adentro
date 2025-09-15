<?php
require_once 'classes/Database.php';
require_once 'models/User.php';

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

    // Hasheo de contraseña (bcrypt por defecto en PHP; suficiente para el práctico)
    $hash    = password_hash($password, PASSWORD_BCRYPT);
    $display = $username; // Para MVP, usamos el mismo username como display_name

    // Insert seguro con parámetros
    $sql = 'INSERT INTO users (username, email, password_hash, role, display_name)
            VALUES (:u, :e, :h, :r, :d)';
    global $userModel;
    $userModel->create([
        'username' => $username,
        'email' => $email,
        'password_hash' => $hash,
        'role' => 'user',
        'display_name' => $display,
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
// Devuelve true si inició correctamente; false si credenciales inválidas o usuario inactivo.
// ------------------------------------------------------------
function login_user(string $login, string $password): bool {
    global $userModel;
    
    // 1) Buscar por username O email usando el modelo User
    $u = $userModel->findByLogin($login);

    // 2) Usuario inexistente o inactivo
    if (!$u) return false;
    if (!(int)$u['is_active']) return false;

    // 3) Verificar contraseña
    if (!password_verify($password, $u['password_hash'])) return false;

    // 4) Guardar identidad y rol en la sesión para el resto del sistema
    $_SESSION['uid']    = (int)$u['id'];       // Identificador del usuario (int)
    $_SESSION['uname']  = $u['username'];      // Nombre de usuario (para mostrar en UI)
    $_SESSION['role']   = $u['role'];          // 'user' | 'admin'

    // 5) Marcar último acceso usando el modelo User
    $userModel->updateLastLogin($u['id']);

    return true;
}


// ------------------------------------------------------------
// logout_user()
// Cierra la sesión de manera segura.
// Flujo:
//   1) Limpia el array $_SESSION (variables en memoria).
//   2) Invalida la cookie de sesión si existe (evita “revivir” la sesión).
//   3) session_destroy() para destruir la sesión del lado del servidor.
// No devuelve nada.
// ------------------------------------------------------------
function logout_user(): void {
    // 1) Vaciar variables de sesión
    $_SESSION = [];

    // 2) Invalidar la cookie de sesión (defensa extra)
    if (ini_get('session.use_cookies')) {
        $p = session_get_cookie_params();
        setcookie(
            session_name(), // nombre de la cookie (igual al session_name activo)
            '',
            time() - 42000, // expirada en el pasado
            $p['path'],
            $p['domain'],
            $p['secure'],
            $p['httponly']
        );
    }

    // 3) Destruir la sesión en el servidor
    session_destroy();
}


// ------------------------------------------------------------
// user_id()
// Devuelve el ID del usuario logueado o NULL si no hay sesión activa.
// Útil para asociar recursos (posts, comentarios) al usuario actual.
// ------------------------------------------------------------
function user_id(): ?int {
    return $_SESSION['uid'] ?? null;
}


// ------------------------------------------------------------
// user_name()
// Devuelve el username del usuario logueado o NULL si no hay sesión.
// Útil para mostrarlo en la interfaz (navbar, comentarios, etc.).
// ------------------------------------------------------------
function user_name(): ?string {
    return $_SESSION['uname'] ?? null;
}


// ------------------------------------------------------------
// user_role()
// Devuelve el rol del usuario actual. Si no hay sesión, por comodidad
// devuelve 'user' (MVP). Si preferís, podés devolver '' y manejar aparte.
// Roles válidos en este proyecto: 'user' y 'admin'.
// ------------------------------------------------------------
function user_role(): string {
    return $_SESSION['role'] ?? 'user';
}


// ------------------------------------------------------------
// require_login()
// “Middleware” simple para proteger páginas que requieren sesión.
// Si no hay usuario logueado, redirige al login y corta la ejecución.
// Ajustá la ruta de login según tu estructura de carpetas.
// ------------------------------------------------------------
function require_login(): void {
    if (!user_id()) {
        http_response_code(302);
        header('Location: /vozdelbarrio/public/login.php');
        exit;
    }
}


// ------------------------------------------------------------
// require_admin()
// “Middleware” para proteger acciones/páginas solo para administradores.
// Si no hay sesión o el rol no es 'admin', responde 403 y termina.
// ------------------------------------------------------------
function require_admin(): void {
    if (!user_id() || user_role() !== 'admin') {
        http_response_code(403);
        exit('Prohibido');
    }
}
