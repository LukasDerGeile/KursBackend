<?php

header('Content-Type: application/json; charset=utf-8');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once $_SERVER['DOCUMENT_ROOT'] . '/ext/sanitize.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/ext/db.php';

$id = REQUESTID;

$post_data = json_decode(file_get_contents('php://input'), true);

$allowed_fields = [
    'kursnummer' => PDO::PARAM_INT,
    'kursthema' => PDO::PARAM_STR,
    'inhalt' => PDO::PARAM_STR,
    'nr_dozent' => PDO::PARAM_INT,
    'startdatum' => PDO::PARAM_STR,
    'enddatum'=> PDO::PARAM_STR,
    'dauer' => PDO::PARAM_INT
];

$pdo = DB::getPdo();

$updated_values = 0;

foreach ($post_data as $i=>$value){
    if(array_key_exists($i, $allowed_fields)){

        $column_name = $i;

        $stmt = $pdo->prepare("UPDATE tbl_kurse SET {$column_name} = :value WHERE id_kurs = :id");
        $stmt->bindValue('value', $value, $allowed_fields[$i]);
        $stmt->bindValue('id', $id, PDO::PARAM_INT);

        
        if($stmt->execute()) {
            $updated_values += $stmt->rowCount();
        } else{
            echo json_encode([
                'status' => 'error',
                'data' => 'An error occured'
            ]);
            http_response_code(500);
            die();    
        }
    }
}

echo json_encode([
    'status' => 'success',
    'data' => "Updated {$updated_values} values"
]);
http_response_code(200);
die();