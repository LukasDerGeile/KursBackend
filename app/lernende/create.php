<?php
header("Content-Type: application/json; charset=utf-8");

require_once $_SERVER["DOCUMENT_ROOT"] . "/ext/sanitizie.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/ext/db.php";

$post_data = json_decode(file_get_contents("php://input"), true);

$vorname = $post_data["vorname"];
$nachname = $post_data["nachname"];
$strasse = $post_data["strasse"];
$plz = $post_data["plz"];
$ort = $post_data["ort"];
$nr_land = $post_data["nr_land"];
$geschlecht = $post_data["geschlecht"];
$telefon = $post_data["telefon"];
$handy = $post_data["handy"];
$email = $post_data["email"];
$email_privat = $post_data["email_privat"];
$birthdate = $post_data["birthdate"];