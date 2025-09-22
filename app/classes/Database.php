
<?php
require_once dirname(__DIR__, 2) . '/config/env.php';
/*
  Using the Database class:
    require_once 'classes/Database.php';

    $db = Database::getInstance()->getConnection();

    $stmt = $db->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => 'test@example.com']);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    print_r($user);
 */
class Database {
    private static $instance = null;
    private $pdo;

    private function __construct() {
        $host = env('DB_HOST');
        $dbname = env('DB_NAME');
        $username = env('DB_USER');
        $password = env('DB_PASSWORD');

        $dsn = "mysql:host={$host};dbname={$dbname};charset=utf8mb4";

        try {
            $this->pdo = new PDO($dsn, $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("DB Connection failed: " . $e->getMessage());
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->pdo;
    }
}
