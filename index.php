<?php

define("APPNAME", "Kursmanagement");
define("ABSPATH", dirname(__FILE__));
define("ABSURL", "https://lukas.undefiniert.ch");

require("app/ext/sanitize.php");
require("app/ext/db.php");

/**
 * cleanAndExtractUrl
 *
 * @return void
 */
function cleanAndExtractUrl()
{
    $requestUrl = isset($_SERVER["REQUEST_URI"]) ? filter_var($_SERVER["REQUEST_URI"], FILTER_SANITIZE_URL) : '/';
    return parse_url($requestUrl);
}

list("path" => $path, "query" => $query) = cleanAndExtractUrl();
define("REQUEST_URI", isset($path) ? trim($path, '/') : '');
define("REQUESTQUERY", isset($query) ? $query : ''); // Added check for 'query' index

$pdo = DB::getPdo();

$requestView = "";

if (REQUEST_URI === "" || REQUEST_URI === "home") {
    $requestView = ABSPATH . "/app/home/index.php";
} else {
    $splitRequestUri = explode("/", REQUEST_URI);
    $route_folder = preg_replace('/[^A-Za-z0-9_]/', '', $splitRequestUri[0] ?? '');
    $route_id = preg_replace('/[^0-9]/', '', $splitRequestUri[1] ?? '');

    if (count($splitRequestUri) === 1) {
        $requestMethod = $_SERVER['REQUEST_METHOD'] ?? '';
        $routeFolderApp = ABSPATH . '/app/' . $route_folder . '/';

        if ($requestMethod === 'GET') {
            define('REQUESTID', 'all');
            $requestView = $routeFolderApp . 'read.php';
        } elseif ($requestMethod === 'POST') {
            $requestView = $routeFolderApp . 'create.php';
        }
    } elseif (count($splitRequestUri) === 2) {
        define('REQUESTID', $route_id);
        $requestMethod = $_SERVER['REQUEST_METHOD'] ?? '';
        $routeFolderApp = ABSPATH . '/app/' . $route_folder . '/';

        if ($requestMethod === 'GET') {
            $requestView = $routeFolderApp . 'read.php';
        } elseif ($requestMethod === 'PUT') {
            $requestView = $routeFolderApp . 'update.php';
        } elseif ($requestMethod === 'DELETE') {
            $requestView = $routeFolderApp . 'delete.php';
        }
    }
}

if (file_exists($requestView)) {
    require_once($requestView);
} else {
    require_once(ABSPATH . '/app/error/not_found.php');
}

?>