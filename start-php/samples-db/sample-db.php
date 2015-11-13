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
// echo "success!";

// 処理
$sql = "select * from users";
$stmt = $dbh->query($sql);
echo "<h3>データベース名: test_db</h3>";
foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $user){
    //  var_dump($user["name"]);
    echo "----------------------------------";
    echo "<br>";
    echo "[ID]: ".$user["id"];
    echo "<br>";
    echo "[NAME]: ".$user["name"];
    echo "<br>";
}
echo "<br>";

// レコードの件数を表示
echo $dbh->query("select count(*) from users")->fetchColumn() . "records found!";

// 切断
$dbh = null;

?>
