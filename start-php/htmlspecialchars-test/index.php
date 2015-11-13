<?php
/**
 * htmlspecialcharsでクロスサイトスクリプティング対応テスト
 *
 * 次を入力
 * <script>alert("危険！スクリプトが実行されました");</script>
 * ※Chromeだと実行されない
 */

echo @$_POST['foo'];
echo htmlspecialchars(@$_POST['bar'], ENT_QUOTES, 'UTF-8');

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <title>htmlspecialchars</title>
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
        <h1 class="text-center">htmlspecialcharsのテスト</h1>
        <form action="" method="POST">
            <div class="col-sm-4 col-sm-offset-4">
                no htmlspecialchars
                <input type="text" id="abc" class="form-control" name="foo" value="">
            </div>
            <div class="col-sm-4 col-sm-offset-4">
                on htmlspecialchars
                <input type="text" id="abc" class="form-control" name="bar" value="">
            </div>
            <button type="submit">送信</button>
        </form>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

</body>
</html>
