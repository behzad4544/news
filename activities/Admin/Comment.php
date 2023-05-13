<?php

namespace Admin;

use database\Database;

class Comment extends Admin
{

    public function index()
    {
        $db = new Database();
        $comments = $db->select('SELECT users.email As email,posts.title AS postTitle, comments.* FROM comments left join users on comments.user_id = users.id left join posts on comments.post_id = posts.id ORDER BY `id` DESC');
        $unseenComments = $db->select('SELECT * FROM comments where status =?', ['unseen']);
        foreach ($unseenComments as $comment) {
            $db->update('comments', $comment['id'], ['status'], ['seen']);
        }
        require_once(BASE_PATH . '/template/admin/comments/index.php');
    }
    public function edit($id)
    {
        $db = new Database();
        $user = $db->select('SELECT * FROM users WHERE `id` =?', [$id])->fetch();
        require_once(BASE_PATH . '/template/admin/users/edit.php');
    }
    public function update($request, $id)
    {
        $db = new Database();
        $db->update("users", $id, array_keys($request), $request);
        $this->redirect("admin/user");
    }

    public function changeStatus($id)
    {
        $db = new Database();
        $comment = $db->select('SELECT * FROM comments WHERE `id` =?', [$id])->fetch();
        if (empty($comment)) {
            $this->redirectBack();
        }
        if ($comment['status'] == "approved") {
            $db->update("comments", $id, ['status'], ['seen']);
        } else {
            $db->update("comments", $id, ['status'], ['approved']);
        }
        $this->redirectBack();
    }
}
