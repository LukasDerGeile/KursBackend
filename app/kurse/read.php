<?php
header("Content-Type: application/json; charset=utf-8");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once dirname(__DIR__) . "/ext/sanitize.php";
require_once dirname(__DIR__) . "/ext/db.php";

$requestUri = $_SERVER["REQUEST_URI"] ?? '/';
$parts = explode('/', rtrim($requestUri, '/'));
$id = end($parts);

try {
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
            http_response_code(404);
            echo json_encode([
                "status" => "error",
                "data" => "It works"
            ]);
        } else {
            http_response_code(200);
            echo json_encode([
                "status" => "success",
                "data" => $rows
            ]);
        }
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        "status" => "error",
        "data" => "Database error: " . $e->getMessage()
    ]);
}
?>
