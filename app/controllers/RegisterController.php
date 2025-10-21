<?php
require_once dirname(__DIR__) . '/classes/Database.php';
require_once dirname(__DIR__) . '/classes/View.php';
require_once dirname(__DIR__) . '/models/User.php';

class RegisterController
{
    private $userModel;
    private $view;

    public function __construct()
    {
        $this->userModel = new User();
        $this->view = new View();
    }

    public function showForm(array $errors = [], array $oldData = []): void
    {
        header('Content-Type: text/html; charset=UTF-8');

        $html = $this->view
            ->withData([
                'errors' => $errors,
                'oldData' => $oldData,
                'title' => 'Registrarse - Puertas Adentro',
                'headerTitle' => 'Puertas Adentro'
            ])
            ->renderWithLayout('auth/register', 'main');

        echo $html;
    }
    public function register(): void
    {
        $email = isset($_POST['email']) ? trim((string)$_POST['email']) : '';
        $confirmEmail = isset($_POST['confirm_email']) ? trim((string)$_POST['confirm_email']) : '';
        $firstName = isset($_POST['first_name']) ? trim((string)$_POST['first_name']) : '';
        $lastName = isset($_POST['last_name']) ? trim((string)$_POST['last_name']) : '';
        $username = isset($_POST['username']) ? trim((string)$_POST['username']) : '';
        $password = isset($_POST['password']) ? (string)$_POST['password'] : '';
        $confirmPassword = isset($_POST['confirm_password']) ? (string)$_POST['confirm_password'] : '';

        $errors = [];
        if ($email === '') $errors[] = 'El email es obligatorio.';
        // Email validacion.
        if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'El email no tiene un formato válido.';
        }
        if ($confirmEmail === '') $errors[] = 'El email de confirmación es obligatorio.';
        if ($email !== '' && $confirmEmail !== '' && $confirmEmail !== $email) $errors[] = 'El email ingresados no coinciden.';
        if ($firstName === '') $errors[] = 'El nombre es obligatorio.';
        if ($lastName === '') $errors[] = 'El apellido es obligatorio.';
        if ($username === '') $errors[] = 'El nombre de usuario es obligatorio.';
        if ($password === '') $errors[] = 'La contraseña es obligatoria.';
        
        // Validacion de registro para creacion segura de password.
        if ($password !== '') {
            if (strlen($password) < 8) {
                $errors[] = 'La contraseña debe tener al menos 8 caracteres.';
            }
            if (!preg_match('/[A-Z]/', $password)) {
                $errors[] = 'La contraseña debe contener al menos una letra mayúscula.';
            }
            if (!preg_match('/[a-z]/', $password)) {
                $errors[] = 'La contraseña debe contener al menos una letra minúscula.';
            }
            if (!preg_match('/[0-9]/', $password)) {
                $errors[] = 'La contraseña debe contener al menos un número.';
            }
            if (!preg_match('/[^\w]/', $password)) {
                $errors[] = 'La contraseña debe contener al menos un carácter especial.';
            }
        }
        if ($confirmPassword === '') $errors[] = 'La confirmación de la contraseña es obligatoria.';
        if ($password !== '' && $confirmPassword !== '' && $password !== $confirmPassword) {
            $errors[] = 'Las contraseñas no coinciden.';
        }
        if ($this->userModel->findByEmail($email)) {
            $errors[] = 'El email ya está registrado.';
        }
        if ($this->userModel->findByUsername($username)) {
            $errors[] = 'El nombre de usuario ya está en uso.';
        }

        if ($errors) {
            $this->showForm($errors, [
                'email' => $email,
                'confirm_email' => $confirmEmail,
                'first_name' => $firstName,
                'last_name' => $lastName,
                'username' => $username
            ]);
            return;
        }

        // Create user
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $userData = [
            'email' => $email,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'username' => $username,
            'password' => $hashedPassword,
            'active' => 1,
            'role' => 'user'
        ];
        try {
            $this->userModel->create($userData);
            error_log('User created, redirecting...');
            header('Location: /login');
            exit;
        } catch (Exception $e) {
            error_log('Error in user creation: ' . $e->getMessage());
            $this->showForm(['Hubo un error al crear el usuario. Intenta nuevamente.']);
            return;
        }
    }
}
