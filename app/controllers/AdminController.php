<?php
require_once dirname(__DIR__) . '/classes/View.php';
require_once dirname(__DIR__) . '/models/User.php';
require_once dirname(__DIR__) . '/models/Post.php';
require_once dirname(__DIR__) . '/models/Comment.php';


class AdminController
{
    private $view;
    private $userModel;
    private $postModel;
    private $commentModel;

    public function __construct()
    {
        $this->view = new View();
        $this->userModel = new User();
        $this->postModel = new Post();
        $this->commentModel = new Comment();
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
        $posts = $this->postModel->getAllPostsWithAuthors();
        $users = $this->userModel->getAllUsers();
        $comments = $this->commentModel->getAllComments();

        $content = $this->view
            ->with('user', $user)
            ->renderWithLayout('dashboard', 'main', [
                'title' => 'Dashboard - Puertas Adentro',
                'headerTitle' => 'Puertas Adentro',
                'posts' => $posts,
                'users' => $users,
                'comments' => $comments
            ]);

        echo $content;
    }
}
