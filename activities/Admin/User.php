<?php

namespace Admin;

use database\Database;

class User extends Admin
{

    public function index()
    {
        $db = new Database();
        $users = $db->select('SELECT * FROM users ORDER BY `id` DESC');
        require_once(BASE_PATH . '/template/admin/users/index.php');
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
        $request = ['username' => $request['username'], 'permission' => $request['permission']];
        $db->update("users", $id, array_keys($request), $request);
        $this->redirect("admin/user");
    }
    public function delete($id)
    {
        $db = new Database();
        $db->delete("users", $id,);
        $this->redirect("admin/user");
    }
    public function permission($id)
    {
        $db = new Database();
        $user = $db->select('SELECT * FROM users WHERE `id` =?', [$id])->fetch();
        if (empty($user)) {
            $this->redirectBack();
        }
        if ($user['permission'] == "admin") {
            $db->update("users", $id, ['permission'], ['user']);
        } else {
            $db->update("users", $id, ['permission'], ['admin']);
        }
        $this->redirectBack();
    }
}
