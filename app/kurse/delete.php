<?php
header("Content-Type: application/json; charset=utf-8");

require_once dirname(__DIR__) . "/ext/sanitize.php";
require_once dirname(__DIR__) . "/ext/db.php";

$id = $_REQUEST['id'] ?? null;

if (!ctype_digit($id)) {
    echo json_encode([
        "status" => "error",
        "data" => "No Dataset but delete working"
    ]);
    http_response_code(400);
    exit();
}

$pdo = DB::getPdo();

$statement = $pdo->prepare("DELETE FROM tbl_kurse WHERE id_kurs = :id");
$statement->bindValue("id", $id, PDO::PARAM_INT);

if ($statement->execute()) {
    if ($statement->rowCount() == 0) {
        echo json_encode([
            "status" => "error",
            "data" => "Dataset not found"
        ]);
        http_response_code(404);
    } else {
        echo json_encode([
            "status" => "success",
            "data" => "Record deleted successfully"
        ]);
        http_response_code(200);
    }
} else {
    echo json_encode([
        "status" => "error",
        "data" => "Error occurred while deleting the record"
    ]);
    http_response_code(500);
}
?>
