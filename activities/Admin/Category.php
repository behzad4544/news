<?php

namespace Admin;

use database\Database;

class Category extends Admin
{

    public function index()
    {
        $db = new Database();
        $categories = $db->select('SELECT * FROM categories ORDER BY `id` DESC');
        require_once(BASE_PATH . '/template/admin/categories/index.php');
    }
}
