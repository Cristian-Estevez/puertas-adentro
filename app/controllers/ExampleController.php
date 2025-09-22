<?php
require_once dirname(__DIR__) . '/classes/View.php';

/**
 * Example controller demonstrating how to use the View system
 */
class ExampleController
{
    private $view;

    public function __construct()
    {
        $this->view = new View();
    }

    /**
     * Example of rendering a simple view
     */
    public function showDashboard(): void
    {
        header('Content-Type: text/html; charset=UTF-8');
        
        // Simulate user data
        $user = [
            'id' => 1,
            'username' => 'admin',
            'role' => 'administrator',
            'last_login' => date('Y-m-d H:i:s')
        ];
        
        $content = $this->view
            ->with('user', $user)
            ->renderWithLayout('dashboard', 'main', [
                'title' => 'Dashboard - Puertas Adentro',
                'headerTitle' => 'Panel de Control'
            ]);
        
        echo $content;
    }

    /**
     * Example of rendering a view with multiple data
     */
    public function showProfile(): void
    {
        header('Content-Type: text/html; charset=UTF-8');
        
        $data = [
            'user' => [
                'name' => 'Juan Pérez',
                'email' => 'juan@example.com',
                'phone' => '+54 11 1234-5678'
            ],
            'settings' => [
                'notifications' => true,
                'theme' => 'dark'
            ]
        ];
        
        $content = $this->view
            ->withData($data)
            ->renderWithLayout('profile', 'main', [
                'title' => 'Perfil de Usuario',
                'headerTitle' => 'Mi Perfil'
            ]);
        
        echo $content;
    }

    /**
     * Example of rendering a view without layout
     */
    public function getPartialContent(): string
    {
        return $this->view
            ->with('message', 'Este es un contenido parcial')
            ->render('partials/alert', ['type' => 'success']);
    }

    /**
     * Example of conditional rendering
     */
    public function showConditionalView(bool $isAdmin = false): void
    {
        header('Content-Type: text/html; charset=UTF-8');
        
        $template = $isAdmin ? 'admin/dashboard' : 'user/dashboard';
        
        $content = $this->view
            ->with('isAdmin', $isAdmin)
            ->renderWithLayout($template, 'main', [
                'title' => $isAdmin ? 'Panel de Administración' : 'Mi Panel'
            ]);
        
        echo $content;
    }
}
