<?php
header("Content-Type: application/json; charset=utf-8");

require_once $_SERVER["DOCUMENT_ROOT"] . "/ext/sanitize.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/ext/db.php";

$data = json_decode(file_get_contents("php://input"), true);

$id = $data["id"] ?? null;
$kursnummer = $data["kursnummer"] ?? null;
$kursthema = $data["kursthema"] ?? null;
$inhalt = $data["inhalt"] ?? null;
$nr_dozent = $data["nr_dozent"] ?? null;
$startdatum = $data["startdatum"] ?? null;
$enddatum = $data["enddatum"] ?? null;
$dauer = $data["dauer"] ?? null;

if (!$id || !$kursnummer || !$kursthema || !$inhalt || !$nr_dozent || !$startdatum || !$enddatum || !$dauer) {
    echo json_encode([
        "status" => "error",
        "data" => "Missing required fields"
    ]);
    http_response_code(400);
    exit();
}

$db = DB::getPdo();
$statement = $db->prepare("UPDATE tbl_kurse SET kursnummer = :kursnummer, kursthema = :kursthema, inhalt = :inhalt, nr_dozent = :nr_dozent, startdatum = :startdatum, enddatum = :enddatum, dauer = :dauer WHERE id_kurs = :id");

$statement->bindParam(":kursnummer", $kursnummer, PDO::PARAM_INT);
$statement->bindParam(":kursthema", $kursthema, PDO::PARAM_STR);
$statement->bindParam(":inhalt", $inhalt, PDO::PARAM_STR);
$statement->bindParam(":nr_dozent", $nr_dozent, PDO::PARAM_INT);
$statement->bindParam(":startdatum", $startdatum, PDO::PARAM_STR);
$statement->bindParam(":enddatum", $enddatum, PDO::PARAM_STR);
$statement->bindParam(":dauer", $dauer, PDO::PARAM_INT);
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
        'data' => 'An error occurred while updating data'
    ]);
    http_response_code(500);
    exit();
}
?>
