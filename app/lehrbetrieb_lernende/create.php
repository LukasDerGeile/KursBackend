<?php
header("Content-Type: application/json; charset=utf-8");

require_once $_SERVER["DOCUMENT_ROOT"] . "/ext/sanitizie.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/ext/db.php";

$post_data = json_decode(file_get_contents("php://input"), true);

$nr_lehrbetrieb = $post_data["nr_lehrbetrieb"];
$nr_lernende = $post_data["nr_lernende"];
$start = $post_data["start"];
$ende = $post_data["ende"];
$beruf = $post_data["beruf"];