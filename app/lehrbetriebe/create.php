<?php
header("Content-Type: application/json; charset=utf-8");

require_once $_SERVER["DOCUMENT_ROOT"] . "/ext/sanitizie.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/ext/db.php";

$post_data = json_decode(file_get_contents("php://input"), true);

$firma = $post_data["firma"];
$starsse = $post_data["strasse"];
$plz = $post_data["plz"];
$ort = $post_data["ort"];