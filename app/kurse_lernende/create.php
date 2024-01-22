<?php

header('Content-Type: application/json; charset=utf-8');

require_once $_SERVER['DOCUMENT_ROOT'] . '/ext/sanitize.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/ext/db.php';


$post_data = json_decode(file_get_contents('php://input'), true);


$id_kurs_lernende = $post_data['id_kurs_lernende'];
$nr_lernende = $post_data['nr_lernende'];
$nr_kurs = $post_data['kurs'];
$note = $post_data['note'];        
$ort = $post_data['ort'];
$nr_land = $post_data['nr_land'];
$geschlecht = $post_data['geschlecht'];  
$telefon = $post_data['telefon'];       
$handy = $post_data['handy'];  
$email = $post_data['email'];
$birthdate = $post_data['birthdate'];  


$pdo = DB::getPdo();

$stmt = $pdo->prepare("INSERT INTO tbl_kurse_lernende(id_kurs_lernende, nr_lernende, kurs, note) "
        . "VALUES (:id_kurs_lernende, :nr_lernende, :nr_kurs, :note, :ort)");


$stmt->bindValue('id_kurs_lernende', $id_kurs_lernende, PDO::PARAM_STR);
$stmt->bindValue('nr_lernende', $nr_lernende, PDO::PARAM_STR);
$stmt->bindValue('kurs', $nr_kurs, PDO::PARAM_STR);
$stmt->bindValue('note', $note, PDO::PARAM_INT);
$stmt->bindValue('ort', $ort, PDO::PARAM_STR);


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
