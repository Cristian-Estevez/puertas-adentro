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
        $stmt = $this->db->prepare(
            "INSERT INTO users (
                email, first_name, last_name, username, password
            ) VALUES (
                :email, :first_name, :last_name, :username, :password
            )"
        );
        $stmt->execute([
            'email'      => $user['email'],
            'first_name' => $user['first_name'],
            'last_name'  => $user['last_name'],
            'username'   => $user['username'],
            'password'   => $user['password']
        ]);
        return $stmt->rowCount() > 0;
    }

    public function update($user, $updatedBy)
    {
        $stmt = $this->db->prepare(
            "UPDATE users 
            SET email = :email, 
                first_name = :first_name, 
                last_name = :last_name, 
                username = :username, 
                password = :password, 
                active = :active, 
                role = :role, 
                created_at = :created_at, 
                updated_at = :updated_at,
                updated_by = :updated_by
            WHERE id = :id"
        );
        $stmt->execute([
            'email'      => $user['email'],
            'first_name' => $user['first_name'],
            'last_name'  => $user['last_name'],
            'username'   => $user['username'],
            'password'   => $user['password'],
            'active'     => $user['active'],
            'role'       => $user['role'],
            'created_at' => $user['created_at'],
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => $updatedBy,
            'id'         => $user['id']
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function delete($id, $updatedBy)
    {
        $stmt = $this->db->prepare(
            "UPDATE users 
            SET active = 0,
                deleted_at = NOW(),
                updated_at = NOW(),
                updated_by = :updated_by
            WHERE id = :id"
        );
        $stmt->execute(['id' => $id, 'updated_by' => $updatedBy]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findByLogin($login)
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM users 
            WHERE username = :login 
            OR email = :login LIMIT 1"
        );
        $stmt->execute(['login' => $login]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateLastLogin($id)
    {
        $stmt = $this->db->prepare(
            "UPDATE users 
            SET last_login_at = NOW()
            WHERE id = :id"
        );
        $stmt->execute(['id' => $id]);
        return $stmt->rowCount() > 0;
    }

    public function updatePassword($id, $hashedPassword, $updatedBy)
    {
        $stmt = $this->db->prepare(
            "UPDATE users 
            SET password = :password, 
                updated_at = NOW(),
                updated_by = :updated_by
            WHERE id = :id"
        );
        $stmt->execute([
            'password' => $hashedPassword,
            'id' => $id,
            'updated_by' => $updatedBy
        ]);
        return $stmt->rowCount() > 0;
    }

    public function getAllUsers()
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM users WHERE deleted_at IS NULL"
        );
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
