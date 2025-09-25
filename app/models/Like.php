<?php
require_once dirname(__DIR__) . '/classes/Model.php';

class Like extends Model
{
    public function countLikesByPostId($postId)
    {
        $stmt = $this->db->prepare(
            "SELECT COUNT(*) as like_count FROM likes 
            WHERE post_id = :post_id"
        );
        $stmt->execute(['post_id' => $postId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? (int)$result['like_count'] : 0;
    }

    public function userHasLikedPost($userId, $postId)
    {
        $stmt = $this->db->prepare(
            "SELECT COUNT(*) as like_count FROM likes 
            WHERE user_id = :user_id 
            AND post_id = :post_id"
        );

        $stmt->execute([
            'user_id' => $userId,
            'post_id' => $postId
        ]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result && (int)$result['like_count'] > 0;
    }

    public function addLike($userId, $postId)
    {
        if ($this->userHasLikedPost($userId, $postId)) {
            return false; // User has already liked the post
        }
        $stmt = $this->db->prepare(
            "INSERT INTO likes (
                user_id, post_id
            ) VALUES (
                :user_id, :post_id
            )
            "
        );
        $stmt->execute([
            'user_id' => $userId,
            'post_id' => $postId
        ]);
        return $stmt->rowCount() > 0;
    }

    public function removeLike($userId, $postId)
    {
        if (!$this->userHasLikedPost($userId, $postId)) {
            return false; // User hasn't liked the post
        }
        $stmt = $this->db->prepare(
            "DELETE FROM likes 
            WHERE user_id = :user_id 
            AND post_id = :post_id"
        );
        $stmt->execute([
            'user_id' => $userId,
            'post_id' => $postId
        ]);
        return $stmt->rowCount() > 0;
    }
}
