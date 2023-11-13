<?php

use ext\DB;
use ext\sanitize;

error_reporting(E_ALL);
ini_set('display_errors', 'On');

define('APPNAME', 'Kursverwaltung');
define('ABSPATH', dirname(__FILE__));
define('ABSURL', 'https://lukas.undefiniert.ch');

require('ext/sanitize.php');
require('ext/db.php');

$requestUrl = filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_URL);
$requestUrl = parse_url($requestUrl);

$path = (isset($requestUrl['path']) ? trim($requestUrl['path'], '/') : '');
$query = (isset($requestUrl['query']) ? $requestUrl['query'] : '');

define('REQUESTURI', $path);
define('REQUESTQUERY', $query);

$pdo = (new DB())->connect();

$requestView = '';

if (REQUESTURI === '' OR REQUESTURI === 'home') {
    $requestView = ABSPATH.'/app/home.php';
} else {
    $split_requesturi = explode('/', REQUESTURI);

    $route_folder = Sanitize::sanitizeRouteFolder($split_requesturi);
    $route_id = Sanitize::sanitizeRouteId($split_requesturi);

    if (count($split_requesturi) === 1) {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            define('REQUESTID', 'all');
            $requestView = ABSPATH.'/app/'.$route_folder.'/read.php';
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $requestView = ABSPATH.'/app/'.$route_folder.'/create.php';
        }
    } elseif (count($split_requesturi) === 2) {
        define('REQUESTID', $route_id);

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $requestView = ABSPATH.'/app/'.$route_folder.'/read.php';
        } elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
            $requestView = ABSPATH.'/app/'.$route_folder.'/update.php';
        } elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            $requestView = ABSPATH.'/app/'.$route_folder.'/delete.php';
        }
    }
}

if (file_exists($requestView)) {
    require_once($requestView);
} else {
    require_once(ABSPATH.'/app/error/not_found.php');
}

echo 'Ja Bruder es funktioniart';
