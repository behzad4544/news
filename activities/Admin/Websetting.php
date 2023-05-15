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
        $setting = $db->select('SELECT * FROM setting WHERE `id` =?', [$id])->fetch();
        if ($request['logo']['tmp_name'] != '') {
            $request['logo'] = $this->saveImage($request['logo'], 'setting-image', 'logo');
        } else {
            unset($request['logo']);
        }
        if ($request['icon']['tmp_name'] != '') {
            $request['icon'] = $this->saveImage($request['icon'], 'setting-image', 'icon');
        } else {
            unset($request['icon']);
        }
        if (!empty($setting)) {
            $db->update("setting", $id, array_keys($request), $request);
        } else {
            $db->insert("setting", array_keys($request), $request);
        }
        $this->redirect("admin/websetting");
    }
}
