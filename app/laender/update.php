<?php
header("Content-Type: application/json; charset=utf-8");

require_once $_SERVER["DOCUMENT_ROOT"] . "/ext/sanitize.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/ext/db.php";

$data = json_decode(file_get_contents("php://input"), true);

$id = $data["id_country"] ?? null;
$country = $data["country"] ?? null;

if (!$id || !$country) {
    echo json_encode([
        "status" => "error",
        "data" => "Missing required fields"
    ]);
    http_response_code(400);
    exit();
}

$db = DB::getPdo();
$statement = $db->prepare("UPDATE tbl_countries SET country = :country WHERE id_country = :id");

$statement->bindParam(":country", $country, PDO::PARAM_STR);
$statement->bindParam(":id", $id, PDO::PARAM_INT);

if ($statement->execute()) {
    echo json_encode([
        "status"=> "success",
        "data"=> "Record updated successfully"
    ]);
    http_response_code(200);
    exit();
} else {
    echo json_encode([
        'status' => 'error',
        'data' => 'An error occurred while updating the record'
    ]);
    http_response_code(500);
    exit();
}
?>
