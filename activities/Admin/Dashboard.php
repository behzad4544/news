<?php

namespace Admin;

use database\Database;

class Dashboard extends Admin
{

    public function index()
    {
        $db = new Database();
        $categoryCount = $db->select("SELECT count(*) FROM categories")->fetch();
        $userCount = $db->select("SELECT count(*) FROM users where permission= 'user'")->fetch();
        $adminCount = $db->select("SELECT count(*) FROM users where permission= 'admin'")->fetch();
        $postCount = $db->select("SELECT count(*) FROM posts")->fetch();
        $postViews = $db->select("SELECT SUM(view) FROM posts")->fetch();
        $commentCount = $db->select("SELECT count(*) FROM comments")->fetch();
        $unseenCommentCount = $db->select("SELECT count(*) FROM comments where status = 'unseen'")->fetch();
        $approvedCommentCount = $db->select("SELECT count(*) FROM comments where status = 'approved'")->fetch();

        require_once(BASE_PATH . '/template/admin/dashboard/index.php');
    }
}
