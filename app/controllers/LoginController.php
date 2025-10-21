<?php
require_once dirname(__DIR__) . '/classes/Database.php';
require_once dirname(__DIR__) . '/classes/View.php';
require_once dirname(__DIR__) . '/models/User.php';

class LoginController
{
    private $userModel;
    private $view;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->userModel = new User();
        $this->view = new View();
    }

    public function showLoginForm(array $errors = [], string $oldLogin = ''): void
    {
        header('Content-Type: text/html; charset=UTF-8');

        $html = $this->view
            ->withData([
                'errors' => $errors,
                'oldLogin' => $oldLogin,
                'title' => 'Iniciar Sesión - Puertas Adentro',
                'headerTitle' => 'Puertas Adentro'
            ])
            ->renderWithLayout('auth/login', 'main');

        echo $html;
    }

    public function authenticate(): void
    {
        $login = isset($_POST['login']) ? trim((string)$_POST['login']) : '';
        $password = isset($_POST['password']) ? (string)$_POST['password'] : '';

        $errors = [];
        if ($login === '') $errors[] = 'El usuario o email es obligatorio.';
        if ($password === '') $errors[] = 'La contraseña es obligatoria.';
        if ($errors) {
            $this->showLoginForm($errors, $login);
            return;
        }

        // Initialize failed attempts counter in session if not present
        if (!isset($_SESSION['failed_login_attempts'])) {
            $_SESSION['failed_login_attempts'] = 0;
        }

        // If there's a locked_until set in session, check if lock is still active
        if (isset($_SESSION['locked_until'])) {
            $now = time();
            $lockedUntil = (int) $_SESSION['locked_until'];
            if ($lockedUntil > $now) {
                $remaining = $lockedUntil - $now;
                // Human-friendly remaining time: show seconds or minutes
                if ($remaining >= 60) {
                    $mins = ceil($remaining / 60);
                    $msg = "Cuenta bloqueada. Intenta nuevamente en {$mins} minuto" . ($mins > 1 ? 's' : '') . ".";
                } else {
                    $msg = "Cuenta bloqueada. Intenta nuevamente en {$remaining} segundos.";
                }
                $this->showLoginForm([$msg], $login);
                return;
            } else {
                // Lock expired: reset counters
                unset($_SESSION['locked_until']);
                $_SESSION['failed_login_attempts'] = 0;
            }
        }

        $user = $this->userModel->findByLogin($login);

        if (!$user || !(int)$user['active'] || !password_verify($password, $user['password'])) {
            // Increment failed attempts in session
            $_SESSION['failed_login_attempts']++;

            // Compute incremental delay: 1,2,4 seconds (cap at 4)
            $attempt = (int)$_SESSION['failed_login_attempts'];
            $delay = (int) min(pow(2, max(0, $attempt - 1)), 4);
            if ($delay > 0) {
                // Delay response to slow brute-force attempts
                sleep($delay);
            }

            // If reached limit, set a temporary lock for 2 minutes and show message
            if ($_SESSION['failed_login_attempts'] >= 5) {
                $_SESSION['locked_until'] = time() + 120; // 2 minutes
                $this->showLoginForm(['Demasiados intentos. Tu cuenta ha sido bloqueada por 2 minutos.'], $login);
            } else {
                $this->showLoginForm(['Credenciales inválidas o usuario inactivo.'], $login);
            }
            return;
        }

    // Successful login: reset failed attempts counter
    $_SESSION['failed_login_attempts'] = 0;

    $_SESSION['uid']   = (int)$user['id'];
    $_SESSION['uname'] = $user['username'];
    $_SESSION['role']  = $user['role'];

    $this->userModel->updateLastLogin($user['id']);

        header('Location: /');
        exit;
    }

    public function logout(): void
    {
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $p = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $p['path'], $p['domain'], $p['secure'], $p['httponly']);
        }
        session_destroy();
        header('Location: /login.php');
        exit;
    }
}
