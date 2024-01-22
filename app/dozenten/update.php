<?php
header("Content-Type: application/json; charset=utf-8");

require_once dirname(__DIR__) . "/ext/sanitize.php";
require_once dirname(__DIR__) . "/ext/db.php";

$data = json_decode(file_get_contents("php://input"), true);

$id = $data["id_dozent"] ?? null;
$vorname = $data["vorname"] ?? null;
$nachname = $data["nachname"] ?? null;
$strasse = $data["strasse"] ?? null;
$plz = $data["plz"] ?? null;
$ort = $data["ort"] ?? null;
$nr_land = $data["nr_land"] ?? null;
$geschlecht = $data["geschlecht"] ?? null;
$telefon = $data["telefon"] ?? null;
$handy = $data["handy"] ?? null;
$email = $data["email"] ?? null;
$birthdate = $data["birthdate"] ?? null;

if (!$id || !$vorname || !$nachname || !$strasse || !$plz || !$ort || !$nr_land || !$geschlecht || !$telefon || !$handy || !$email || !$birthdate) {
    echo json_encode([
        "status" => "error",
        "data" => "Missing required fields"
    ]);
    http_response_code(400);
    exit();
}

$db = DB::getPdo();
$statement = $db->prepare("UPDATE tbl_dozenten SET vorname = :vorname, nachname = :nachname, strasse = :strasse, plz = :plz, ort = :ort, nr_land = :nr_land, geschlecht = :geschlecht, telefon = :telefon, handy = :handy, email = :email, birthdate = :birthdate WHERE id_dozent = :id");

$statement->bindParam(":vorname", $vorname, PDO::PARAM_STR);
$statement->bindParam(":nachname", $nachname, PDO::PARAM_STR);
$statement->bindParam(":strasse", $strasse, PDO::PARAM_STR);
$statement->bindParam(":plz", $plz, PDO::PARAM_STR);
$statement->bindParam(":ort", $ort, PDO::PARAM_STR);
$statement->bindParam(":nr_land", $nr_land, PDO::PARAM_INT);
$statement->bindParam(":geschlecht", $geschlecht, PDO::PARAM_STR);
$statement->bindParam(":telefon", $telefon, PDO::PARAM_STR);
$statement->bindParam(":handy", $handy, PDO::PARAM_STR);
$statement->bindParam(":email", $email, PDO::PARAM_STR);
$statement->bindParam(":birthdate", $birthdate, PDO::PARAM_STR);
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
