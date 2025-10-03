<?php
require_once dirname(__DIR__) . '/classes/View.php';

class HomeController
{
    private $view;

    public function __construct()
    {
        $this->view = new View();
    }

    public function showView(): void
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
            ->renderWithLayout('home', 'main', [
                'title' => 'Home - Puertas Adentro',
                'headerTitle' => 'Puertas Adentro'
            ]);
        
        echo $content;
    }
}