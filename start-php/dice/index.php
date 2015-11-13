<?php

$dice1 = mt_rand(1,6);
$dice2 = mt_rand(1,6);

$zorome = ($dice1 == $dice2) ? true : false;

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>サイコロのテスト</title>
    <style>
    </style>
    <!-- <link rel="stylesheet" href="style.css"> -->
</head>
<body>
    <h1>サイコロのテストです！</h1>
    <p>
        サイコロの目は...「<?php echo $dice1 ?>」「<?php echo $dice2 ?>」です。
        <?php if ($zorome) : ?>
            ゾロ目です！やったね！
        <?php endif; ?>
    </p>
    <p><a href="<?php echo $_SERVER["SCRIPT_NAME"]; ?>">もう一度！</a></p>
</body>
</html>
