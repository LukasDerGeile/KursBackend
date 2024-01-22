<?php
header("Content-Type: application/json; charset=utf-8");

require_once dirname(__DIR__) . "/ext/sanitize.php";
require_once dirname(__DIR__) . "/ext/db.php";

$post_data = json_decode(file_get_contents("php://input"), true);

$vorname = $post_data["vorname"] ?? null;
$nachname = $post_data["nachname"] ?? null;
$strasse = $post_data["strasse"] ?? null;
$plz = $post_data["plz"] ?? null;
$ort = $post_data["ort"] ?? null;
$nr_land = $post_data["nr_land"] ?? null;
$geschlecht = $post_data["geschlecht"] ?? null;
$telefon = $post_data["telefon"] ?? null;
$handy = $post_data["handy"] ?? null;
$email = $post_data["email"] ?? null;
$email_privat = $post_data["email_privat"] ?? null;
$birthdate = $post_data["birthdate"] ?? null;

if (!$vorname || !$nachname || !$strasse || !$plz || !$ort || !$nr_land || !$geschlecht || !$telefon || !$handy || !$email || !$email_privat || !$birthdate) {
    echo json_encode([
        "status" => "error",
        "data" => "Missing required fields"
    ]);
    http_response_code(400);
    exit();
}

$db = DB::getPdo();
$statement = $db->prepare("INSERT INTO tbl_lernende (vorname, nachname, strasse, plz, ort, nr_land, geschlecht, telefon, handy, email, email_privat, birthdate) VALUES (:vorname, :nachname, :strasse, :plz, :ort, :nr_land, :geschlecht, :telefon, :handy, :email, :email_privat, :birthdate)");

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
$statement->bindParam(":email_privat", $email_privat, PDO::PARAM_STR);
$statement->bindParam(":birthdate", $birthdate, PDO::PARAM_STR);

if ($statement->execute()) {
    $lastId = $db->lastInsertId();
    echo json_encode([
        "status"=> "success",
        "data"=> ['id_lernende' => $lastId]
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
