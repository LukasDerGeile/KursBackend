<?php

header('Content-Type: application/json; charset=utf-8');

require_once $_SERVER['DOCUMENT_ROOT'] . '/ext/sanitize.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/ext/db.php';


$post_data = json_decode(file_get_contents('php://input'), true);


$vorname = $post_data['vorname'];
$nachname = $post_data['nachname'];
$strasse = $post_data['strasse'];
$plz = $post_data['plz'];        
$ort = $post_data['ort'];
$nr_land = $post_data['nr_land'];
$geschlecht = $post_data['geschlecht'];  
$telefon = $post_data['telefon'];       
$handy = $post_data['handy'];  
$email = $post_data['email'];
$birthdate = $post_data['birthdate'];  


$pdo = DB::getPdo();

$stmt = $pdo->prepare("INSERT INTO tbl_dozenten (vorname, nachname, strasse, plz, ort, nr_land, geschlecht, telefon, handy, email, birthdate) "
        . "VALUES (:vorname, :nachname, :strasse, :plz, :ort, :nr_land, :geschlecht, :telefon, :handy, :email, :birthdate)");


$stmt->bindValue('vorname', $vorname, PDO::PARAM_STR);
$stmt->bindValue('nachname', $nachname, PDO::PARAM_STR);
$stmt->bindValue('strasse', $strasse, PDO::PARAM_STR);
$stmt->bindValue('plz', $plz, PDO::PARAM_INT);
$stmt->bindValue('ort', $ort, PDO::PARAM_STR);
$stmt->bindValue('nr_land', $plz, PDO::PARAM_INT);
$stmt->bindValue('geschlecht', $geschlecht, PDO::PARAM_STR);
$stmt->bindValue('telefon', $telefon, PDO::PARAM_INT);
$stmt->bindValue('handy', $handy, PDO::PARAM_INT);
$stmt->bindValue('email', $email, PDO::PARAM_STR);
$stmt->bindValue('birthdate', $birthdate, PDO::PARAM_STR);


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
