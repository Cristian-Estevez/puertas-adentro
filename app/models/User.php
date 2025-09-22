<?php
require_once dirname(__DIR__) . '/classes/Model.php';

class User extends Model
{
    public function findByEmail($email)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findByUsername($username)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function create($user)
    {
        $stmt = $this->db->prepare("
        INSERT INTO users (
            email, first_name, last_name, username, password, active, role
        ) VALUES (
            :email, :first_name, :last_name, :username, :password, :active, :role
        )
    ");
        $stmt->execute($user);
        return $stmt->rowCount() > 0;
    }



    public function update($user)
    {
        $stmt = $this->db->prepare("UPDATE users SET email = :email, first_name = :first_name, last_name = :last_name, username = :username, password = :password, active = :active, role = :role, created_at = :created_at, updated_at = :updated_at WHERE id = :id");
        $stmt->execute($user);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("UPDATE users SET active = 0 WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findByLogin($login)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :login OR email = :login LIMIT 1");
        $stmt->execute(['login' => $login]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateLastLogin($id)
    {
        $stmt = $this->db->prepare("UPDATE users SET last_login_at = NOW() WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->rowCount() > 0;
    }

    public function updatePassword($id, $hashedPassword)
    {
        $stmt = $this->db->prepare("UPDATE users SET password = :password, updated_at = NOW() WHERE id = :id");
        $stmt->execute(['password' => $hashedPassword, 'id' => $id]);
        return $stmt->rowCount() > 0;
    }
}
