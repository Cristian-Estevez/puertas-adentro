<?php
require_once dirname(__DIR__) . '/classes/Model.php';

class Post extends Model
{
    public function findById($id)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM posts
            WHERE id = :id
        ");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($post)
    {
        $stmt = $this->db->prepare("
            INSERT INTO posts (
                created_by, title, body, image_base64
            ) VALUES (
                :created_by, :title, :body, :image_base64
            )
        ");

        $now = date('Y-m-d H:i:s');

        $stmt->execute([
            ':created_by' => $post['created_by'],
            ':title'      => $post['title'],
            ':body'       => $post['body'],
            ':image_base64' => $post['image_base64'] ?? null,
        ]);

        return $this->db->lastInsertId();
    }


    public function update($post)
    {
        $stmt = $this->db->prepare("
            UPDATE posts 
            SET 
                title = :title,
                body = :body,
                image_base64 = :image_base64,
                updated_by = :updated_by,
                updated_at = :updated_at
            WHERE id = :id
        ");

        $stmt->execute([
            ':title'       => $post['title'],
            ':body'        => $post['body'],
            ':image_base64' => $post['image_base64'] ?? null,
            ':updated_by'  => $post['updated_by'],
            ':updated_at'  => date('Y-m-d H:i:s'),
            ':id'          => $post['id']
        ]);

        return $stmt->rowCount() > 0;
    }


    public function delete($id, $updatedBy)
    {
        $stmt = $this->db->prepare("
            UPDATE posts 
            SET deleted_at = :deleted_at, updated_by = :updated_by 
            WHERE id = :id
        ");

        $stmt->execute([
            'id' => $id,
            'deleted_at' => date('Y-m-d H:i:s'),
            'updated_by' => $updatedBy
        ]);

        return $stmt->rowCount() > 0;
    }

    public function getAllPosts()
    {
        $stmt = $this->db->prepare("
            SELECT * FROM posts WHERE deleted_at IS NULL
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
