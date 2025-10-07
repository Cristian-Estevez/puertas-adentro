<?php
require_once dirname(__DIR__) . '/classes/View.php';
require_once dirname(__DIR__) . '/models/Admin.php';
require_once dirname(__DIR__) . '/models/User.php';

class AdminController
{
    private $view;
    private $adminModel;
    private $userModel;

    public function __construct()
    {
        $this->view = new View();
        $this->adminModel = new Admin();
        $this->userModel = new User();
    }

    private function validateAdminAccess(): void
    {
        $userId = $_SESSION['uid'] ?? null;
        if (!$userId) {
            header('Content-Type: application/json');
            http_response_code(401);
            echo json_encode(['error' => 'Not authenticated']);
            exit;
        }

        $user = $this->userModel->findById($userId);
        if (!$user || $user['role'] !== 'admin') {
            header('Content-Type: application/json');
            http_response_code(403);
            echo json_encode(['error' => 'Unauthorized. Admin access required.']);
            exit;
        }
    }

    public function hasPopulateDBScriptRun(): bool
    {
        $this->validateAdminAccess();
        return $this->adminModel->populateDBHasRan();
    }

    public function markPopulateDBAsRan(): void
    {
        header('Content-Type: application/json');
        $this->validateAdminAccess();

        
        if ($this->hasPopulateDBScriptRun()) {
            http_response_code(400);
            echo json_encode(['error' => 'The populate DB script has already run.']);
            exit;
        }
        
        if ($this->adminModel->markPopulateDBAsRan()) {
            echo json_encode(['message' => 'Database population marked as completed successfully.']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to mark database population as completed.']);
        }
        exit;
    }

    public function showView(): void
    {
        header('Content-Type: text/html; charset=UTF-8');
        $this->validateAdminAccess();

        // Get logged in user data from session
        $userId = $_SESSION['uid'] ?? null;
        if (!$userId) {
            header('Location: /login.php');
            exit;
        }
        $user = $this->userModel->findById($userId);

        $content = $this->view
            ->with('user', $user)
            ->renderWithLayout('dashboard', 'main', [
                'title' => 'Dashboard - Puertas Adentro',
                'headerTitle' => 'Puertas Adentro'
            ]);

        echo $content;
    }
}
