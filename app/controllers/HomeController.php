<?php
require_once dirname(__DIR__) . '/classes/View.php';
require_once dirname(__DIR__) . '/models/Post.php';
require_once dirname(__DIR__) . '/models/User.php';
require_once dirname(__DIR__) . '/models/Comment.php';
require_once dirname(__DIR__) . '/utils/date-utils.php';

session_start();

class HomeController
{
    private $view;
    private $userModel;
    private $postModel;
    private $commentModel;

    public function __construct()
    {
        $this->view = new View();
        $this->postModel = new Post();
        $this->commentModel = new Comment();
        $this->userModel = new User();
    }

    public function showView(): void
    {
        header('Content-Type: text/html; charset=UTF-8');

        // Get logged in user data from session
        $userId = $_SESSION['uid'] ?? null;
        if (!$userId) {
            header('Location: /login.php');
            exit;
        }
        $user = $this->userModel->findById($userId);
        $posts = $this->postModel->getAllPosts();

        $postsWithData = [];
        foreach ($posts as $post) {
            $comments = $this->commentModel->getCommentsByPostId($post['id']);
            $commentsWithAutor = [];
            foreach ($comments as $comment) {
                $commentAuthor = $this->userModel->findById($comment['created_by']);
                $comment['author'] = $commentAuthor;
                $commentsWithAutor[] = $comment;
            }

            $author = $this->userModel->findById($post['created_by']);

            $post['updated_at_es'] = formatToSpanish($post['updated_at']);
            $post['comments'] = $commentsWithAutor;
            $post['author'] = $author;

            $postsWithData[] = $post;
        }

        $content = $this->view
            ->with('user', $user)
            ->renderWithLayout('home', 'main', [
                'title' => 'Noticias del Barrio',
                'headerTitle' => 'Puertas Adentro',
                'posts' => $postsWithData
            ]);

        echo $content;
    }
}
