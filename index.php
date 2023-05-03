<?php

session_start();

define('BATH_PATH', __DIR__);
define('CURRENT_DOMAIN', currentdomain() . "/news/");
define('DISPLAY_ERROR', true);
define('DB_HOST', 'localhost');
define('DB_NAME', 'news');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'root');


//helpers

function protocol()
{
    return stripos($_SERVER['SERVER_PROTOCOL'], "https") === true ? 'https://' : 'http://';
}

function currentDomain()
{
    return protocol() . $_SERVER['HTTP_HOST'];
}


function asset($src)
{
    $domain = trim(CURRENT_DOMAIN, "/ ");
    $src = $domain . "/" . trim($src, '/');
    return $src;
}

function url($url)
{
    $domain = trim(CURRENT_DOMAIN, "/ ");
    $url = $domain . "/" . trim($url, '/');
    return $url;
}

function currentUrl()
{
    return currentDomain() . $_SERVER['REQUEST_URI'];
}

function methodField()
{
    return $_SERVER['REQUEST_METHOD'];
}

function displayError($displayError)
{
    if ($displayError) {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    } else {
        ini_set('display_errors', 0);
        ini_set('display_startup_errors', 0);
        error_reporting(0);
    }
}

global $flashMessage;
if (isset($_SESSION['flash_Message'])) {
    $flashMessage = $_SESSION['flash_Message'];
    unset($_SESSION['flash_Message']);
}

function flash($name, $value = null)
{
    if ($value === null) {
        global $flashMessage;
        $message = isset($flashMessage[$name]) ? $flashMessage[$name] : '';
        return $message;
    } else {
        $_SESSION['flash_Message']['name'] = $value;
    }
}
