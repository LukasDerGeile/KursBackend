<?php
header("Content-Type: application/json; charset=utf-8");

require_once $_SERVER["DOCUMENT_ROOT"] . "/ext/sanitize.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/ext/db.php";

$post_data = json_decode(file_get_contents("php://input"), true);

$country = $post_data["country"] ?? null;

if (!$country) {
    echo json_encode([
        "status" => "error",
        "data" => "Missing required fields"
    ]);
    http_response_code(400);
    exit();
}

$db = DB::getPdo();
$statement = $db->prepare("INSERT INTO tbl_countries (country) VALUES (:country)");
$statement->bindParam(":country", $country, PDO::PARAM_STR);

if ($statement->execute()) {
    $lastId = $db->lastInsertId();
    echo json_encode([
        "status"=> "success",
        "data"=> ['id_country' => $lastId]
    ]);
    http_response_code(200);
    exit();
} else {
    echo json_encode([
        'status' => 'error',
        'data' => 'An error occurred while inserting data'
    ]);
    http_response_code(500);
    exit();
}
?>
