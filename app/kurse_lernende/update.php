<?php
header("Content-Type: application/json; charset=utf-8");

require_once $_SERVER["DOCUMENT_ROOT"] . "/ext/sanitize.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/ext/db.php";

$data = json_decode(file_get_contents("php://input"), true);

$id = $data["id_kurs_lernende"] ?? null;
$nr_lernende = $data["nr_lernende"] ?? null;
$nr_kurs = $data["nr_kurs"] ?? null;
$note = $data["note"] ?? null;

if (!$id || !$nr_lernende || !$nr_kurs || !$note) {
    echo json_encode([
        "status" => "error",
        "data" => "Missing required fields"
    ]);
    http_response_code(400);
    exit();
}

$db = DB::getPdo();
$statement = $db->prepare("UPDATE tbl_kurse_lernende SET nr_lernende = :nr_lernende, nr_kurs = :nr_kurs, note = :note WHERE id_kurs_lernende = :id");

$statement->bindParam(":nr_lernende", $nr_lernende, PDO::PARAM_INT);
$statement->bindParam(":nr_kurs", $nr_kurs, PDO::PARAM_INT);
$statement->bindParam(":note", $note, PDO::PARAM_STR);
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
