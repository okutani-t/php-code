<?php
/**
 * エルビス演算子のテスト
 *
 * $hoge = isset($_POST['foo']) ? $_POST['foo'] : 'bar';
 * が
 * $hoge = @$_POST['foo'] ?: 'bar';
 * とすっきりかけちゃうよ、ってやつ
 */
$hoge = @$_POST['foo'] ?: 'bar';

echo "<h2>" . $hoge . "</h2>";

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <title>エルビス演算子のテスト</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.2/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body>
    <div class="container">
        <h1 class="text-center">エルビス演算子のテスト</h1>
        <form action="" method="POST">
            <div class="col-sm-4 col-sm-offset-4">
                <input type="text" id="abc" class="form-control" name="foo" value="0">
            </div>

            <button type="submit">送信</button>
        </form>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

</body>
</html>
