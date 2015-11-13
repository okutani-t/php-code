<?php
/**
 * CSRF対策を試してみたやつ
 *
 * @author okutani
 */

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    _validateToken();
} else {
    _createToken();
}

// トークンの生成
function _createToken()
{
    if (!isset($_SESSION['token'])) {
        $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(16));
    }
}

// トークンのチェック
function _validateToken()
{
    if (
    !isset($_SESSION['token']) ||
    !isset($_POST['token']) ||
    $_SESSION['token'] !== $_POST['token']
    ) {
        throw new Exception('invalid token!');
    } else {
        echo "token check is ok";
    }
}

function h($s)
{
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>CSRF対策</title>
</head>
<body>
    <form action="" method="post">
        <input type="text" name="name" value="taro">
        <input type="hidden" name="answer" value="1">
        <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
        <input type="submit" value="送信">
    </form>
</body>
</html>
