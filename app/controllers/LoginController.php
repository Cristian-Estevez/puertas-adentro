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

        $user = $this->userModel->findByLogin($login);

        if (!$user || !(int)$user['active'] || !password_verify($password, $user['password'])) {
            $this->showLoginForm(['Credenciales inválidas o usuario inactivo.'], $login);
            return;
        }

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
