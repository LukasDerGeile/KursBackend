<?php
header("Content-Type: application/json; charset=utf-8");

require_once dirname(__DIR__) . "/ext/sanitize.php";
require_once dirname(__DIR__) . "/ext/db.php";

$post_data = json_decode(file_get_contents("php://input"), true);

$nr_lehrbetrieb = $post_data["nr_lehrbetrieb"] ?? null;
$nr_lernende = $post_data["nr_lernende"] ?? null;
$start = $post_data["start"] ?? null;
$ende = $post_data["ende"] ?? null;
$beruf = $post_data["beruf"] ?? null;

if (!$nr_lehrbetrieb || !$nr_lernende || !$start || !$ende || !$beruf) {
    echo json_encode([
        "status" => "error",
        "data" => "Missing required fields"
    ]);
    http_response_code(400);
    exit();
}

$db = DB::getPdo();
$statement = $db->prepare("INSERT INTO tbl_lehrbetriebe_lernende (nr_lehrbetrieb, nr_lernende, start, ende, beruf) VALUES (:nr_lehrbetrieb, :nr_lernende, :start, :ende, :beruf)");

$statement->bindParam(":nr_lehrbetrieb", $nr_lehrbetrieb, PDO::PARAM_INT);
$statement->bindParam(":nr_lernende", $nr_lernende, PDO::PARAM_INT);
$statement->bindParam(":start", $start, PDO::PARAM_STR);
$statement->bindParam(":ende", $ende, PDO::PARAM_STR);
$statement->bindParam(":beruf", $beruf, PDO::PARAM_STR);

if ($statement->execute()) {
    $lastId = $db->lastInsertId();
    echo json_encode([
        "status"=> "success",
        "data"=> ['id_lehrbetrieb_lernende' => $lastId]
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
