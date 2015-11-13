<?php
// formでgetのテスト
// @はデバッグ大変になるのであんまり使わないほうがいいかも

$name = @$_GET["name"];
$age  = @$_GET["age"];

echo $name;
echo $age;

?>
<!DOCTYPE html>
<html lang='ja'>
<head>
    <meta charset='utf-8'>
    <title>FormでGET</title>
    <style>
    body {
        width: 940px;
        margin: auto;
    }
    </style>
</head>
<body>
    <h1>FormでGET通信テスト</h1>
    <form action="" method="get">
        <label>お名前</label><input type="text" name="name" value="<?= $name ?>"><br><br>
        <label>年齢</label><input type="text" name="age" value="<?= $age ?>">歳
        <input type="submit" value="GET送信">
    </form>
</body>
</html>
