<?php
header("Content-Type: application/json; charset=utf-8");

require_once dirname(__DIR__) . "/ext/sanitize.php";
require_once dirname(__DIR__) . "/ext/db.php";

$post_data = json_decode(file_get_contents("php://input"), true);

$firma = $post_data["firma"] ?? null;
$strasse = $post_data["strasse"] ?? null;
$plz = $post_data["plz"] ?? null;
$ort = $post_data["ort"] ?? null;

if (!$firma || !$strasse || !$plz || !$ort) {
    echo json_encode([
        "status" => "error",
        "data" => "Missing required fields"
    ]);
    http_response_code(400);
    exit();
}

$db = DB::getPdo();
$statement = $db->prepare("INSERT INTO tbl_lehrbetriebe (firma, strasse, plz, ort) VALUES (:firma, :strasse, :plz, :ort)");

$statement->bindParam(":firma", $firma, PDO::PARAM_STR);
$statement->bindParam(":strasse", $strasse, PDO::PARAM_STR);
$statement->bindParam(":plz", $plz, PDO::PARAM_STR);
$statement->bindParam(":ort", $ort, PDO::PARAM_STR);

if ($statement->execute()) {
    $lastId = $db->lastInsertId();
    echo json_encode([
        "status"=> "success",
        "data"=> ['id_lehrbetrieb' => $lastId]
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
