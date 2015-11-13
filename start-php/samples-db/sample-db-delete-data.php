<?php

// データベースへの接続
try{
    $dbh = new PDO('mysql:host=localhost;dbname=test_db','root','5k3ffsawe09r');
}catch(PDOException $e){
    var_dump($e->getMessage());
    exit;
}

// データの削除
$stmt = $dbh->prepare("delete from users where id > 4");
$stmt->execute();

echo $stmt->rowCount() . "records deleted ";

echo "done.";
// 切断
$dbh = null;

?>
