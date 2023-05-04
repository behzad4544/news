<?php

session_start();

define('BATH_PATH', __DIR__);
define('CURRENT_DOMAIN', currentdomain() . "/news/");
define('DISPLAY_ERROR', true);
define('DB_HOST', 'localhost');
define('DB_NAME', 'news');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'root');
require "database/DataBase.php";

$conn = new database\Database();

// routing function
function uri($reservedUrl, $class, $method, $requrestMethod = 'GET')
{
    //current url array
    $currentUrl = explode('?', currentUrl())[0];
    dd($currentUrl);
    $currentUrl = str_replace(CURRENT_DOMAIN, '', $currentUrl);
    $currentUrl = trim($currentUrl, '/');
    $currentUrlArray = explode('/', $currentUrl);
    $currentUrlArray = array_filter($currentUrlArray);

    //Reserved Url array
    $reservedUrl = trim($reservedUrl, '/');
    $reservedUrlArray = explode('/', $reservedUrl);
    $reservedUrlArray = array_filter($reservedUrlArray);

    if (sizeof($currentUrlArray) != sizeof($reservedUrlArray) || methodField() != $requrestMethod) {
        return false;
    }
    $parameters = [];
    for ($key = 0; $key < sizeof($currentUrlArray); $key++) {
        if ($reservedUrlArray[$key][0] == "{" && $reservedUrlArray[$key][strlen($reservedUrlArray[$key]) - 1] == "}") {
            array_push($parameters, $currentUrlArray[$key]);
        } elseif ($currentUrlArray[$key] !== $reservedUrlArray[$key]) {
            return false;
        }
    }
    if (methodField() == "POST") {
        $request = isset($_FILES) ? array_merge($_POST, $_FILES) : $_POST;
        $parameters = array_merge([$request], $parameters);
    }
    $object = new $class;
    call_user_func_array(array($object, $method), $parameters);
    exit();
}


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
function dd($var)
{
    echo "<pre>";
    var_dump($var);
    exit();
}