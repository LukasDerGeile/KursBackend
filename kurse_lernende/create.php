<?php
header("Content-Type: application/json; charset=utf-8");

require_once $_SERVER["DOCUMENT_ROOT"] . "/ext/sanitizie.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/ext/db.php";

$post_data = json_decode(file_get_contents("php://input"), true);

$nr_lernende = $post_data["nr_lernende"];
$nr_kurs = $post_data["nr_kurs"];
$note = $post_data["note"];