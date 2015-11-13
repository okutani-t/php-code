<?php

$omikuzi = array("凶","小吉","吉","大吉");

$result = $omikuzi[mt_rand(0, count($omikuzi) - 1)];

?>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>おみくじ</title>
    <style>
    a {
        background-color: skyblue;
        padding: 10px;
        text-decoration: none;
        border-radius: 6px;
        color: #555;
    }
    </style>
    <!-- <link rel="stylesheet" href="style.css"> -->
</head>
<body>
    <h1>おみくじ</h1>
    <p>今日の運勢は...「<?php echo $result; ?>」です！</p>
    <p><a href="<?php echo $_SERVER["SCRIPT_NAME"]; ?>">もう一度！</a></p>
</body>
</html>
