<?php

namespace ReactBlog\Backend\models;

use ReactBlog\Backend\models\BaseModel;

class CategoryModel extends BaseModel
{
    public function getTopCategories()
    {
        $sql = "
            SELECT * FROM categories
            LEFT OUTER JOIN posts_categories
                 ON categories.id = posts_categories.category_id
            LEFT OUTER JOIN posts
                 ON posts_categories.post_id = posts.id
            GROUP BY categories.id
            ORDER BY COUNT(posts.id) DESC
            LIMIT 5;
        ";
        return $this->query($sql);
    }

    public function getCategories($page, $limit)
    {
        $offset = ($page - 1) * $limit;
        $sql = "
            SELECT * FROM categories
            LIMIT :limit OFFSET :offset;
        ";
        $params = [
            'limit' => $limit,
            'offset' => $offset,
        ];
        return $this->query($sql, $params);
    }

    public function addCategory($name)
    {
        $sql = "
            INSERT IGNORE INTO categories (name) VALUES (:name);
        ";
        $params = [
            'name' => $name,
        ];
        return $this->query($sql, $params);
    }

    public function createMultipleCategories($categories) // TODO make user of RETURNING clause
    {
        $sql = "
            INSERT IGNORE INTO categories (name) VALUES 
        ";
        $params = [];
        $categoriesCount = count($categories);
        for ($i = 0; $i < $categoriesCount; $i++) {
            $sql .= '(:name'.$i.')';
            $params[] = [
                'name'.$i => $categories[$i],
            ];
        }
        $sql .= ';';
        $this->query($sql, $params);
        $sql2 = "
            SELECT id FROM categories WHERE name IN (".implode(',', array_fill(0, $categoriesCount, '?')).");
        "; // TODO fix this query
        return $this->query($sql2, $categories);
    }
}