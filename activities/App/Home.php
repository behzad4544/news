<?php

namespace App;


class Home
{
    public function index()
    {
        require_once(BASE_PATH . '/template/app/index.php');
    }
    public function show($id)
    {
    }
    public function category($id)
    {
    }
    public function commentStore($request)
    {
    }
    protected function redirectBack()
    {
        header('Location:' . $_SERVER['HTTP_REFERER']);
        exit;
    }
}
