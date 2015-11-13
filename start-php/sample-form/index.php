<?php

require_once('config.php');
require_once('functions.php');

session_start();

if($_SERVER['REQUEST_METHOD'] != 'POST') {
    // 投稿前

    // CSRF対策
    setToken();
}else {
    // 投稿後
    checkToken();

    $name = $_POST['name'];
    $email = $_POST['email'];
    $memo = $_POST['memo'];

    $error = array();

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error['email'] = '不正なメールだぜ';
    }
    if ($name == ''){
        $error['name'] = '名前を入力してね';
    }
    if ($email == '') {
        $error['email'] = 'メルアド入力してね';
    }
    if ($memo == '') {
        $error['memo'] = '内容を入力してね';
    }

    if (empty($error)) {
        // DBに格納
        $dbh = connectDb();

        $sql = "insert into entries
        (name, email, memo, created, modified)
        values
        (:name, :email, :memo, now(), now())";
        $stmt = $dbh->prepare($sql);
        $params = array(
            ":name" => $name,
            ":email" => $email,
            ":memo" => $memo
        );
        $stmt->execute($params);

        header('Location:'.SITE_URL.'thanks.html');
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang='ja'>
<head>
    <meta charset='utf-8'>
    <title>お問い合わせフォーム</title>
    <style>
    body {
        width: 80%;
        height: auto;
        margin: 0 auto;
        text-align: center;
        border: 1px solid #ccc;
        box-shadow: 0 0 2px #ccc;
    }
    .input {
        padding-bottom: 500px;
    }
    p {
        font-size: 22px;
    }
    </style>
</head>
<body>
    <h1>お問い合わせフォームです</h1>
    <form method='POST' action=''>
        <p>
            お名前*: <input type='text' name='name' value='<?php echo h($name); ?>' >
            <?php if($error['name']) { echo h($error['name']); } ?>
        </p>
        <p>
            メールアドレス*: <input type='text' name='email' value='<?php echo h($email); ?>' >
            <?php if($error['email']) { echo h($error['email']); } ?>
        </p>
        <p>内容*: </p>
        <p>
            <textarea name='memo' rows='5' cols='40'><?php echo h($memo); ?></textarea>
            <?php if($error['memo']) { echo h($error['memo']); } ?>
        </p>
        <p><input type='submit' value='送信'></p>
        <input type='hidden' name='token' value='<?php echo h($_SESSION['token']); ?>'>
    </form>
</body>
</html>
