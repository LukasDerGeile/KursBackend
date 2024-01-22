<?php
header("Content-Type: application/json; charset=utf-8");

require_once dirname(__DIR__) . "/ext/sanitize.php";
require_once dirname(__DIR__) . "/ext/db.php";

$data = json_decode(file_get_contents("php://input"), true);

$id = $data["id_lehrbetrieb_lernende"] ?? null;
$nr_lehrbetrieb = $data["nr_lehrbetrieb"] ?? null;
$nr_lernende = $data["nr_lernende"] ?? null;
$start = $data["start"] ?? null;
$ende = $data["ende"] ?? null;
$beruf = $data["beruf"] ?? null;

if (!$id || !$nr_lehrbetrieb || !$nr_lernende || !$start || !$ende || !$beruf) {
    echo json_encode([
        "status" => "error",
        "data" => "Missing required fields"
    ]);
    http_response_code(400);
    exit();
}

$db = DB::getPdo();
$statement = $db->prepare("UPDATE tbl_lehrbetriebe_lernende SET nr_lehrbetrieb = :nr_lehrbetrieb, nr_lernende = :nr_lernende, start = :start, ende = :ende, beruf = :beruf WHERE id_lehrbetrieb_lernende = :id");

$statement->bindParam(":nr_lehrbetrieb", $nr_lehrbetrieb, PDO::PARAM_INT);
$statement->bindParam(":nr_lernende", $nr_lernende, PDO::PARAM_INT);
$statement->bindParam(":start", $start, PDO::PARAM_STR);
$statement->bindParam(":ende", $ende, PDO::PARAM_STR);
$statement->bindParam(":beruf", $beruf, PDO::PARAM_STR);
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
