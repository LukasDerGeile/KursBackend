<?php
header("Content-Type: application/json; charset=utf-8");

require_once $_SERVER["DOCUMENT_ROOT"] . "/ext/sanitize.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/ext/db.php";

$id = $_REQUEST['id'] ?? null;

if (!ctype_digit($id)) {
    echo json_encode([
        "status" => "error",
        "data" => "Invalid ID provided"
    ]);
    http_response_code(400);
    exit();
}

$db = DB::getPdo();
$statement = $db->prepare("DELETE FROM tbl_lehrbetriebe WHERE id_lehrbetrieb = :id");
$statement->bindParam("id", $id, PDO::PARAM_INT);

if ($statement->execute()) {
    if ($statement->rowCount() == 0) {
        echo json_encode([
            "status"=> "error",
            "data"=> "Dataset not found"
        ]);
        http_response_code(404);
    } else {
        echo json_encode([
            "status"=> "success",
            "data"=> "Record deleted successfully"
        ]);
        http_response_code(200);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'data' => 'An error occurred while deleting the record'
    ]);
    http_response_code(500);
}
?>
