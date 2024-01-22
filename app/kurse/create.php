<?php

header('Content-Type: application/json; charset=utf-8');

require_once $_SERVER['DOCUMENT_ROOT'] . '/ext/sanitize.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/ext/db.php';

$post_data = json_decode(file_get_contents('php://input'), true);

$kursnummer = $post_data['kursnummer'];
$kursthema = $post_data['kursthema'];
$inhalt = $post_data['inhalt'];
$nr_dozent = $post_data['nr_dozent'];        
$startdatum = $post_data['startdatum'];
$enddatum = $post_data['enddatum'];
$dauer_tage = $post_data['dauer_tage'];       

$pdo = DB::getPdo();

$stmt = $pdo->prepare("INSERT INTO tbl_kurse (kursnummer, kursthema, inhalt, nr_dozent, startdatum, enddatum, dauer_tage) "
        . "VALUES (:kursnummer, :kursthema, :inhalt, :nr_dozent, :startdatum, :enddatum, :dauer_tage)");
$stmt->bindValue('kursnummer', $kursnummer, PDO::PARAM_INT);
$stmt->bindValue('kursthema', $kursthema, PDO::PARAM_STR);
$stmt->bindValue('inhalt', $inhalt, PDO::PARAM_STR);
$stmt->bindValue('nr_dozent', $nr_dozent, PDO::PARAM_INT);
$stmt->bindValue('startdatum', $startdatum, PDO::PARAM_STR);
$stmt->bindValue('enddatum', $enddatum, PDO::PARAM_STR);
$stmt->bindValue('dauer_tage', $dauer_tage, PDO::PARAM_INT);

if($stmt->execute()) {
    echo json_encode([
            'status' => 'success',
            'data' => ['id' => $pdo->lastInsertId()]
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

