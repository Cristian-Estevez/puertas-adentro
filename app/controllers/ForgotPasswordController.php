<?php
require_once dirname(__DIR__) . '/classes/Database.php';
require_once dirname(__DIR__) . '/classes/View.php';
require_once dirname(__DIR__) . '/models/User.php';

class ForgotPasswordController
{
    private $userModel;
    private $view;

    public function __construct()
    {
        $this->userModel = new User();
        $this->view = new View();
    }

    public function showForm(array $errors = [], string $oldLogin = '', bool $success = false) : void {
        header('Content-Type: text/html; charset=UTF-8');

        $html = $this->view
            ->withData([
                'errors' => $errors,
                'oldLogin' => $oldLogin,
                'success' => $success,
                'title' => 'Recuperar contraseña — Puertas Adentro',
                'headerTitle' => 'Puertas Adentro'
            ])
            ->renderWithLayout('auth/forgot-password', 'main');

        echo $html;
    }

    public function resetPassword() : void {
        $login = isset($_POST['login']) ? trim((string)$_POST['login']) : '';
        $password = isset($_POST['password']) ? (string)$_POST['password'] : '';

        $login = isset($_POST['login']) ? trim((string)$_POST['login']) : '';
        $password = isset($_POST['password']) ? (string)$_POST['password'] : '';

        $errors = [];
        if ($login === '') $errors[] = 'El usuario o email es obligatorio.';
        if ($password === '') $errors[] = 'La contraseña es obligatoria.';
        if ($errors) {
            $this->showForm($errors, $login);
            return;
        }

        $user = $this->userModel->findByLogin($login);

        if (!$user || !(int)$user['active']) {
            $this->showForm(['No podemos realizar este cambio en este momento'], $login);
            return;
        }

        // change password logic here
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $this->userModel->updatePassword((int)$user['id'], $hashedPassword, (int)$user['id']);
        $this->showForm([], '', true);
    }
}
