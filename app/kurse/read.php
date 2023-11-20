<?php
header("Content-Type: application/json; charset=utf-8");

require_once $_SERVER["DOCUMENT_ROOT"] . "/ext/sanitize.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/ext/db.php";

$id = REQUESTID;

$pdo = DB::getPdo();

if ($id === "all") {
    $statement = $pdo->prepare("SELECT * FROM tbl_kurse");
} else {
    $statement = $pdo->prepare("SELECT * FROM tbl_kurse WHERE id_kurs = :id LIMIT 1");
}