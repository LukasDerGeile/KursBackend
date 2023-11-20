<?php

// Definiere Konstanten für die Anwendung
define("APPNAME", "Kursmanagement");
define("ABSPATH", dirname(__FILE__));
define("ABSURL", "https://lukas.undefiniert.ch");

// Erforderliche Dateien für die Datenbankverbindung einbinden
require("ext/sanitize.php");
require("ext/db.php");

// Funktion zur Bereinigung und Extraktion der URL definieren
function cleanAndExtractUrl()
{
    $requestUrl = filter_var($_SERVER["REQUEST_URI"], FILTER_SANITIZE_URL);
    return parse_url($requestUrl);
}

// Konstanten für die Anfrage-URL und Abfrage definieren
list("path" => $path, "query" => $query) = cleanAndExtractUrl();
define("REQUEST_URI", isset($path) ? trim($path, '/') : '');
define("REQUESTQUERY", isset($query) ? $query : '');

// PDO-Datenbankverbindung initialisieren
$pdo = DB::getPdo();

// Initialisierung der Variablen für die angeforderte Ansicht
$requestView = "";

// Prüfen und Festlegen der angeforderten Ansicht basierend auf der URL
if (REQUEST_URI === "" || REQUEST_URI === "home") {
    $requestView = ABSPATH . "/app/home/index.php";
} else {
    // Aufteilen der URL und Bestimmen des Ordners und der ID
    $splitRequestUri = explode("/", REQUEST_URI);
    $route_folder = preg_replace('/[^A-Za-z0-9_]/', '', $splitRequestUri[0] ?? '');
    $route_id = preg_replace('/[^0-9]/', '', $splitRequestUri[1] ?? '');

    // Anzahl der Teile in der URL überprüfen
    if (count($splitRequestUri) === 1) {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $routeFolderApp = ABSPATH . '/app/' . $route_folder . '/';

        if ($requestMethod === 'GET') {
            define('REQUESTID', 'all');
            $requestView = $routeFolderApp . 'read.php';
        } elseif ($requestMethod === 'POST') {
            $requestView = $routeFolderApp . 'create.php';
        }
    } elseif (count($splitRequestUri) === 2) {
        define('REQUESTID', $route_id);
        $requestMethod = $_SERVER['REQUEST_METHOD'];
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

// Ansicht überprüfen und laden
if (file_exists($requestView)) {
    require_once($requestView);
} else {
    require_once(ABSPATH . '/app/error/not_found.php');
}
?>
