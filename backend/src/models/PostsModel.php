<?php

namespace ReactBlog\Backend\models;

use ReactBlog\Backend\exceptions\NotFoundException;
use ReactBlog\Backend\models\BaseModel;

class PostsModel extends BaseModel {
    public function getPosts($page, $limit, $userId = null) {
        if ($page < 1) {
            throw new \Exception('Invalid page');
        }
        if ($limit < 1 || $limit > 100) {
            throw new \Exception('Invalid limit');
        }
        $offset = ($page - 1) * $limit;
        $params = [];
        $sql = "
            SELECT posts.id, posts.title, posts.content, users.username, categories.name AS category_name
            FROM posts
            LEFT OUTER JOIN users
                ON posts.user_id = users.id
            LEFT OUTER JOIN posts_categories
                ON posts.id = posts_categories.post_id
            LEFT OUTER JOIN categories
                ON posts_categories.category_id = categories.id
        ";
        if ($userId) {
            $sql .= "WHERE posts.user_id = :user_id";
            $params['user_id'] = $userId;
        }
        $sql .= "
            ORDER BY posts.created_at DESC
            LIMIT :limit OFFSET :offset;
        ";
        $params['limit'] = $limit;
        $params['offset'] = $offset;
        $result = [];
        $posts = $this->query($sql, $params);
        $result['posts'] = $posts;
        $params = [];
        $sql = "
            SELECT COUNT(*) AS count
            FROM posts
        ";
        if ($userId) {
            $sql .= "WHERE posts.user_id = :user_id";
            $params['user_id'] = $userId;
        }
        try {
            $count = $this->query($sql, $params);
            $result['count'] = $count[0]['count'];
        } catch (\Exception $e) {
            echo $e->getMessage();
            $result['count'] = 0;
        }
        return $result;
    }

    public function getPost($id) {
        $sql = "
            SELECT posts.id, posts.title, posts.content, users.username, categories.name AS category_name
            FROM posts
            LEFT OUTER JOIN users
                ON posts.user_id = users.id
            LEFT OUTER JOIN posts_categories
                ON posts.id = posts_categories.post_id
            LEFT OUTER JOIN categories
                ON posts_categories.category_id = categories.id
            WHERE posts.id = :id;
        ";
        $params = [
            'id' => $id,
        ];
        return $this->query($sql, $params);
    }

    public function createPost($userId, $title, $content, $categories) {
        $sql = "
            INSERT INTO posts (user_id, title, content) VALUES (:user_id, :title, :content);
        ";
        $params = [
            'user_id' => $userId,
            'title' => $title,
            'content' => $content,
        ];
        $this->query($sql, $params);
        $postId = $this->db->lastInsertId();
        $categoryIds = (new CategoryModel)->createMultipleCategories($categories);
        $sql = "
            INSERT IGNORE INTO posts_categories (post_id, category_id) VALUES 
        ";
        $params = [
            'post_id' => $postId,
        ];
        $categoriesCount = count($categoryIds);
        for ($i = 0; $i < $categoriesCount; $i++) {
            $sql .= '(:post_id, :category_id'.$i.')';
            $params['category_id'.$i] = $categoryIds[$i];
        }
        $this->query($sql, $params);
        return $postId;
    }

    public function deletePost($id, $userId = null) { // TODO optimize queries
        $post = null;
        if ($userId) {
            $post = $this->getPost($id);
            $post = $post[0];
            if (!$post || $post['user_id'] !== $userId) {
                throw new NotFoundException('Post not found');
            }
        }
        $sql = "
            DELETE FROM posts_categories WHERE post_id = :id;
        ";
        $params = [
            'id' => $id,
        ];
        $this->query($sql, $params);
        $sql = "
            DELETE FROM posts WHERE id = :id;
        ";
        $this->query($sql, $params);
        return $post;
    }

    public function editPost($postId, $updateData, $userId = null) {
        $deletedPostData = $this->deletePost($postId, $userId); // TODO done this to do it faster, but it's not the best way
        $mergedData = array_merge($deletedPostData, $updateData);
        return $this->createPost($userId, $mergedData['title'], $mergedData['content'], $mergedData['categories']);
    }
}