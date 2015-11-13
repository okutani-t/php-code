<?php

// BINGO ルール

// B: 1-15
// I: 16-30
// N: 31-45(中央なし)
// G: 46-60
// O: 61-75

$bingo = array();

for($i = 0;$i < 5;$i++){
    // 1-15個の配列を作る
    $numbers = range($i*15 + 1, $i*15 + 15);
    shuffle($numbers);
    $bingo[$i] = array_slice($numbers, 0, 5);
}
// var_dump($bingo);

$s = "";

for($j = 0; $j < 5; $j++){
    $s .= "<tr>";
    for($k = 0; $k < 5; $k++){
        $s .= ($j == 2 && $k == 2) ? "<td>◉</td>" : sprintf("<td>%s</td>",$bingo[$k][$j]);
    }
    $s .= "</tr>";
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>BINGO</title>
    <style>
    body {
        width: 600px;
        margin: 0 auto;
    }
    p {
        text-align: center;
    }
    h1 {
        text-align: center;
    }
    td, th {
        width: 110px;
        height: 50px;
        border: 1px solid #ccc;
        box-shadow: 1px 1px 2px #ccc;
        text-align: center;
        font-size: 17px;
    }
    th {
        background-color: skyblue;
    }
    </style>
    <!-- <link rel="stylesheet" href="style.css"> -->
</head>
<body>
    <h1>BINGO!</h1>
    <p>ビンゴをしましょう！</p>
    <table>
        <tr><th>B</th><th>I</th><th>N</th><th>G</th><th>O</th></tr>
        <?php echo $s;  ?>
    </table>
</body>
</html>
