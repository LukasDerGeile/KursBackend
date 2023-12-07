<?php
header("Content-Type: application/json; charset=utf-8");

require_once $_SERVER["DOCUMENT_ROOT"] . "/ext/sanitize.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/ext/db.php";

$post_data = json_decode(file_get_contents("php://input"), true);

$nr_lernende = $post_data["nr_lernende"] ?? null;
$nr_kurs = $post_data["nr_kurs"] ?? null;
$note = $post_data["note"] ?? null;

if (!$nr_lernende || !$nr_kurs || !$note) {
    echo json_encode([
        "status" => "error",
        "data" => "Missing required fields"
    ]);
    http_response_code(400);
    exit();
}

$db = DB::getPdo();
$statement = $db->prepare("INSERT INTO tbl_kurse_lernende (nr_lernende, nr_kurs, note) VALUES (:nr_lernende, :nr_kurs, :note)");

$statement->bindParam(":nr_lernende", $nr_lernende, PDO::PARAM_INT);
$statement->bindParam(":nr_kurs", $nr_kurs, PDO::PARAM_INT);
$statement->bindParam(":note", $note, PDO::PARAM_STR);

if ($statement->execute()) {
    $lastId = $db->lastInsertId();
    echo json_encode([
        "status"=> "success",
        "data"=> ['id_kurs_lernende' => $lastId]
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
