<?php
header("Content-Type: application/json; charset=utf-8");

require_once $_SERVER["DOCUMENT_ROOT"] . "/ext/sanitize.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/ext/db.php";

$id = REQUESTID;

$pdo = DB::getPdo();

$statement = $pdo->prepare("DELETE FROM tbl_kurse WHERE id_kurs = :id");
$statement->bindValue("id", $id, PDO::PARAM_INT);

if ($statement->execute()) {
    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
    
    if ($statement->rowCount() == 0) {
        echo json_encode([
            "status"=> "error",
            "data"=> "Dataset not found"
        ]);
        http_response_code(500);
        die();
    } else {
        echo json_encode([
            "status"=> "success",
            "data"=> ""
        ]);
    }
    http_response_code(200);
    die();
}
?>
