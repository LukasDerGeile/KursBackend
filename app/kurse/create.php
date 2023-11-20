<?php
header("Content-Type: application/json; charset=utf-8");

require_once $_SERVER["DOCUMENT_ROOT"] . "/ext/sanitizie.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/ext/db.php";

$decode = json_decode(file_get_contents("php://input"), true);

$kursnummer = $decode["kursnummer"];
$kursthema = $decode["kursthema"];
$inhalt = $decode["inhalt"];
$nr_dozent = $decode["nr_dozent"];
$startdatum = $decode["startdatum"];
$enddatum = $decode["enddatum"];
$dauer = $decode["dauer"];

$db = DB::getPdo();
$statement = $db->prepare("INSERT INTO tbl_kurse (kursnummer, kursthema, inhalt, nr_dozent, startdatum, enddatum, dauer)" . "VALUES (:kursnummer, :kursthema, :inhalt, :nr_dozent, :startdatum, :enddatum, :dauer)");

$statement->bindValue("kursnummer", $kursnummer, PDO::PARAM_INT);
$statement->bindValue("kursthema", $kursthema, PDO::PARAM_STR);
$statement->bindValue("inhalt", $inhalt, PDO::PARAM_STR);
$statement->bindValue("nr_dozent", $nr_dozent, PDO::PARAM_INT);
$statement->bindValue("startdatum", $startdatum, PDO::PARAM_STR);
$statement->bindValue("enddatum", $enddatum, PDO::PARAM_STR);
$statement->bindValue("dauer", $dauer, PDO::PARAM_INT);

if ($statement->execute()) {
    echo json_encode([
        "status"=> "success",
        "data"=> ['id' => $pdo->lastInsertId()]
    ]);

    http_response_code(200);
    die();

} else{
    echo json_encode([
        'status' => 'error',
        'data' => 'An error occured'
    ]);

    http_response_code(500);
    die();    
}
