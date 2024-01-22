<?php
header("Content-Type: application/json; charset=utf-8");

require_once dirname(__DIR__) . "/ext/sanitize.php";
require_once dirname(__DIR__) . "/ext/db.php";

$pdo = DB::getPdo();

$requestUri = $_SERVER["REQUEST_URI"];
$parts = explode('/', rtrim($requestUri, '/'));

$id = end($parts);

if (ctype_digit($id)) {
    $statement = $pdo->prepare("SELECT * FROM tbl_countries WHERE id_country = :id LIMIT 1");
    $statement->bindParam("id", $id, PDO::PARAM_INT);
} else {
    $statement = $pdo->prepare("SELECT * FROM tbl_countries");
}

if ($statement->execute()) {
    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

    if (empty($rows)) {
        echo json_encode([
            "status" => "error",
            "data" => "It works"
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
