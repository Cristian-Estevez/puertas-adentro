<?php
require_once dirname(__DIR__) . '/classes/Model.php';

class Comment extends Model
{
    public function findById($id)
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM comments
            WHERE id = :id"
        );
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($comment)
    {
        $stmt = $this->db->prepare(
            "INSERT INTO comments (
                text, post_id, created_by
            ) VALUES (
                 :text, :post_id, :created_by
            )"
        );

        $stmt->execute([
            ':post_id'    => $comment['post_id'],
            ':created_by' => $comment['created_by'],
            ':text'       => $comment['text']
        ]);

        return $this->db->lastInsertId();
    }

    public function update($comment)
    {
        $stmt = $this->db->prepare(
            "UPDATE comments 
            SET 
                text = :text,
                updated_by = :updated_by,
                updated_at = :updated_at
            WHERE id = :id"
        );

        $stmt->execute([
            ':text'        => $comment['text'],
            ':updated_by'  => $comment['updated_by'],
            ':updated_at'  => date('Y-m-d H:i:s'),
            ':id'          => $comment['id']
        ]);

        return $stmt->rowCount() > 0;
    }

    public function getCommentsByPostId($postId)
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM comments
            WHERE post_id = :post_id AND deleted_at IS NULL"
        );
        $stmt->execute(['post_id' => $postId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delete($id, $updatedBy)
    {
        $stmt = $this->db->prepare(
            "UPDATE comments 
            SET deleted_at = :deleted_at, updated_by = :updated_by
            WHERE id = :id"
        );

        $stmt->execute([
            ':deleted_at'  => date('Y-m-d H:i:s'),
            ':updated_by'  => $updatedBy,
            ':id'          => $id
        ]);

        return $stmt->rowCount() > 0;
    }
}