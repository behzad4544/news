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
        $mostViewedPosts = $db->select("SELECT * from posts order by view desc limit 0,5")->fetchAll();
        $mostCommentedPosts = $db->select("SELECT posts.id,posts.title,count(comments.post_id) AS comments_count from posts left join comments on posts.id = comments.post_id group by posts.id order by comments_count desc limit 0,5")->fetchAll();
        $lastComments = $db->select("SELECT comments.id,comments.comment,comments.status,comments.post_id,users.username from comments,users where comments.user_id = users.id order by comments.created_at desc limit 0,5")->fetchAll();

        require_once(BASE_PATH . '/template/admin/dashboard/index.php');
    }
}
