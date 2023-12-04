<?php
header("Content-Type: application/json; charset=utf-8");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once $_SERVER["DOCUMENT_ROOT"] . "/ext/sanitize.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/ext/db.php";

$requestUri = $_SERVER["REQUEST_URI"];
$parts = explode('/', rtrim($requestUri, '/'));

$id = end($parts);

$pdo = DB::getPdo();

if (ctype_digit($id)) {
    $statement = $pdo->prepare("SELECT * FROM tbl_kurse WHERE id_kurs = :id LIMIT 1");
    $statement->bindValue("id", $id, PDO::PARAM_INT);
} else {
    $statement = $pdo->prepare("SELECT * FROM tbl_kurse");
}

if ($statement->execute()) {
    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

    if (empty($rows)) {
        echo json_encode([
            "status" => "error",
            "data" => "Dataset not found"
        ]);
        http_response_code(404);
    } else {
        echo json_encode([
            "status" => "success",
            "data" => $rows
        ]);
        http_response_code(200);
    }
}
?>
