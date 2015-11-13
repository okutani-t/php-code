<?php

// データベースへの接続前処理
$dsn = 'mysql:host=localhost;dbname=test_db';
$duser = 'root';
$dpass = '5k3ffsawe09r';

// データベースへの接続前処理
try{
    $dbh = new PDO($dsn, $duser, $dpass);
}catch(PDOException $e){
    var_dump($e->getMessage());
    exit;
}

// auto incrementのリセット処理
$stmt = $dbh->prepare("ALTER TABLE users AUTO_INCREMENT = 1;");

$stmt->execute();

echo "done reset auto increment.";

?>
