<?php
$food = "";
if(!empty($_POST)){
    $food = $_POST["b"];
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>ラジオボタンのテスト</title>
    <style>
    body {
        text-align: center;
    }
    </style>
    <!-- <link rel="stylesheet" href="style.css"> -->
</head>
<body>
    <h1>ラジオボタンのテストです</h1>
    <p>好きなモノを選んでください</p>
    <form method="POST" action="radio-info.php">
        <label><input type="radio" name="b" value="カレー" checked>カレー</label>
        <label><input type="radio" name="b" value="冷やし中華">冷やし中華</label>
        <label><input type="radio" name="b" value="マーマレード">マーマレード</label>
        <input type="submit" value="送信します">
    </form>
    <br>
    <?php echo $food ?>
</body>
</html>
