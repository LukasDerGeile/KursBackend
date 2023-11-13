<?php

// enable error reporting
error_reporting(E_ALL & ~E_NOTICE);

// config
define('APPNAME', 'Kursverwaltung');
define('ABSPATH', dirname(__FILE__));
define('ABSURL', 'https://modul295.pr24.dev');

// load classes
require('ext/sanitize.php');
require('ext/db.php');

// get request uri
$requestUrl = filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_URL);
$requestUrl = parse_url($requestUrl);

$path = (isset($requestUrl['path']) ? trim($requestUrl['path'], '/') : '');
$query = (isset($requestUrl['query']) ? $requestUrl['query'] : '');

define('REQUESTURI', $path);
define('REQUESTQUERY', $query);

// db connection
$pdo = DB::getPdo();

// routing
$requestView = '';

// routing: home
if (REQUESTURI === '' OR REQUESTURI === 'home') {
    $requestView = ABSPATH.'/app/home/index.php';
} else {
    // split path: get parameters and count
    $split_requesturi = explode('/', REQUESTURI);

    // sanitize params
    $route_folder = (isset($split_requesturi[0]) && !preg_match('/[^A-Za-z0-9_]/', $split_requesturi[0])) ? $split_requesturi[0] : '';
    $route_id = (isset($split_requesturi[1]) && !preg_match('/[^0-9]/', $split_requesturi[1])) ? $split_requesturi[1] : '';

    // Switch-Case für REQUEST_METHOD
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            define('REQUESTID', (count($split_requesturi) === 1) ? 'all' : $route_id);
            $requestView = ABSPATH.'/app/'.$route_folder.'/read.php';
            break;
        case 'POST':
            $requestView = ABSPATH.'/app/'.$route_folder.'/create.php';
            break;
        case 'PUT':
            define('REQUESTID', $route_id);
            $requestView = ABSPATH.'/app/'.$route_folder.'/update.php';
            break;
        case 'DELETE':
            define('REQUESTID', $route_id);
            $requestView = ABSPATH.'/app/'.$route_folder.'/delete.php';
            break;
    }
}

// File-Existenzprüfung mit ternärem Operator
$requestView = file_exists($requestView) ? $requestView : ABSPATH.'/app/error/not_found.php';
require_once($requestView);
