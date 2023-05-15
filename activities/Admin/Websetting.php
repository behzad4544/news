<?php

namespace Admin;

use database\Database;

class Websetting extends Admin
{

    public function index()
    {
        $db = new Database();
        $setting = $db->select('SELECT * FROM setting ORDER BY `id` DESC')->fetch();
        require_once(BASE_PATH . '/template/admin/websettings/index.php');
    }
    public function edit($id)
    {
        $db = new Database();
        $setting = $db->select('SELECT * FROM setting WHERE `id` =?', [$id])->fetch();
        require_once(BASE_PATH . '/template/admin/websettings/edit.php');
    }
    public function update($request, $id)
    {
        $db = new Database();
        if ($request['logo']['tmp_name'] != null && $request['icon']['tmp_name'] != null) {
            $setting = $db->select('SELECT * FROM setting WHERE `id` =?', [$id])->fetch();
            $this->removeImage($setting['logo']);
            $this->removeImage($setting['icon']);
            $request['image'] = $this->saveImage($request['logo'], 'setting-image');
            $request['image'] = $this->saveImage($request['icon'], 'setting-image');
        } else {
            unset($request['logo']);
            unset($request['icon']);
        }
        $db->update("setting", $id, array_keys($request), $request);
        $this->redirect("admin/websetting");
    }
}
