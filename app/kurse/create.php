<?php
header("Content-Type: application/json; charset=utf-8");

require_once $_SERVER["DOCUMENT_ROOT"] . "/ext/sanitize.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/ext/db.php";

$data = json_decode(file_get_contents("php://input"), true);

$kursnummer = $data["kursnummer"] ?? null;
$kursthema = $data["kursthema"] ?? null;
$inhalt = $data["inhalt"] ?? null;
$nr_dozent = $data["nr_dozent"] ?? null;
$startdatum = $data["startdatum"] ?? null;
$enddatum = $data["enddatum"] ?? null;
$dauer = $data["dauer"] ?? null;

if (!$kursnummer || !$kursthema || !$inhalt || !$nr_dozent || !$startdatum || !$enddatum || !$dauer) {
    echo json_encode([
        "status" => "error",
        "data" => "Missing required fields"
    ]);
    http_response_code(400);
    exit();
}

$db = DB::getPdo();
$statement = $db->prepare("INSERT INTO tbl_kurse (kursnummer, kursthema, inhalt, nr_dozent, startdatum, enddatum, dauer) VALUES (:kursnummer, :kursthema, :inhalt, :nr_dozent, :startdatum, :enddatum, :dauer)");

$statement->bindParam(":kursnummer", $kursnummer, PDO::PARAM_INT);
$statement->bindParam(":kursthema", $kursthema, PDO::PARAM_STR);
$statement->bindParam(":inhalt", $inhalt, PDO::PARAM_STR);
$statement->bindParam(":nr_dozent", $nr_dozent, PDO::PARAM_INT);
$statement->bindParam(":startdatum", $startdatum, PDO::PARAM_STR);
$statement->bindParam(":enddatum", $enddatum, PDO::PARAM_STR);
$statement->bindParam(":dauer", $dauer, PDO::PARAM_INT);

if ($statement->execute()) {
    $lastId = $db->lastInsertId();
    echo json_encode([
        "status"=> "success",
        "data"=> ['id' => $lastId]
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
