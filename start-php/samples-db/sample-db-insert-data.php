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

// データの挿入処理
$stmt = $dbh->prepare("insert into users (name,email,password) values (:name,:email,:pass)");
$stmt->bindParam(":name",$name);
$stmt->bindParam(":email",$email);
$stmt->bindParam(":pass",$pass);

// ループさせて複数のデータを挿入
for($i = 0; $i < 10; $i++) {
    $name = "sato".$i;
    $email = "sato@gmail.com".$i;
    $pass = "sato123sato".$i;
    echo $i." ";
    // 実行
    $stmt->execute();
}

echo "done.";
// 切断
$dbh = null;

?>
