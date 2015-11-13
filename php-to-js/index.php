<?php
/**
 * PHPからJSへ値を受け渡してみたテスト
 *
 * @author okutani
 */

$ary = array(
    "hoge" => 1,
    "huga" => 324,
    "haga" => "abc"
);

$obj = new StdClass();

$obj->name = array("田中", "森下");
$obj->age = array(17, 46);

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <title>PHPからjsへ値受け渡し</title>
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
        <h1 class="text-center">PHPからJSへ</h1>

        <div class="col-sm-4 col-sm-offset-4">
            <input type="text" id="abc" class="form-control" name="namae[]" value="">
        </div>

        <div class="col-sm-4 col-sm-offset-4">
            <input type="text" class="form-control" name="namae[]" value="">
        </div>

        <div class="col-sm-4 col-sm-offset-4">
            <input type="text" id="abc" class="form-control" name="namae[]" value="">
        </div>

        <div class="col-sm-4 col-sm-offset-4">
            <input type="text" class="form-control" name="namae[]" value="">
        </div>

    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script>

    // エスケープ処理してPHPから値を取得
    var ary = <?php echo json_encode($ary, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;

    //document.getElementById('abc').value = ary['huga'];
    document.getElementsByName("namae[]")[0].value = 1;
    document.getElementsByName('namae[]')[1].value = ary.huga;

    // objectの場合
    var obj = <?php echo json_encode($obj, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;

    document.getElementsByName("namae[]")[2].value = obj.name[1];
    document.getElementsByName('namae[]')[3].value = obj.age[0];

    // if smarty code
    // {$var|@json_encode}
    </script>
</body>
</html>
