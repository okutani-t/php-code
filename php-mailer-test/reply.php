<?php
/**
 * PHPMailerのテスト(reply)
 *
 * @author okutani
 */
// PHPMailer読み込み
require './PHPMailer/PHPMailerAutoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    /****************************
     * 送信情報設定
     ****************************/
    $from    = 'from@test.com';
    $to      = array(
        'okutani.nt@gmail.com'
    );
    $reply   = $_POST["email"];

    // 内容
    $mySubject = 'SOFからお問い合わせがありました';
    $myBody    = '名前: ' . $_POST["name"] .
                 "\n年齢: " . $_POST["age"] .
                 "\nメールアドレス: " . $_POST["email"];

    $toSubject =  '[自動返信]お問い合わせありがとうございます';
    $toBody    =  "以下の内容でメールを送信しました。\n\n" .
                  "名前: " . $_POST["name"] .
                  "\n年齢: " . $_POST["age"] .
                  "\nメールアドレス: " . $_POST["email"] .
                  "\n\n今後ともよろしくお願いいたします。";

    // タイムゾーン設定
    date_default_timezone_set('Asia/Tokyo');

    /****************************
     * 自分宛てメール
     ****************************/
    $myMail = new PHPMailer;

    // 文字エンコーディングの設定
    $myMail->CharSet = "UTF-8";    // 文字セット(デフォルトは'ISO-8859-1')
    $myMail->Encoding = "base64";  // エンコーディング(デフォルトは'8bit')

    // 送信先やCC等の設定
    $myMail->setFrom($from);
    foreach ($to as $value) {
        $myMail->addAddress($value);
    }

    // テキストメールの場合
    $myMail->isHTML(false);

    // 件名
    $myMail->Subject = $mySubject;
    // 本文
    $myMail->Body    = $myBody;

    if (!$myMail->send()) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $myMail->ErrorInfo;
    } else {
        echo 'メールが送信されました(my)！';
    }

    /****************************
     * 自動返信メール
     ****************************/
    $toMail = new PHPMailer;

    // 文字エンコーディングの設定
    $toMail->CharSet = "UTF-8";    // 文字セット(デフォルトは'ISO-8859-1')
    $toMail->Encoding = "base64";  // エンコーディング(デフォルトは'8bit')

    // 送信先やCC等の設定
    $toMail->setFrom($from);
    $toMail->addAddress($reply);

    // テキストメールの場合
    $toMail->isHTML(false);

    // 件名
    $toMail->Subject = $toSubject;
    // 本文
    $toMail->Body    = $toBody;

    if (!$toMail->send()) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $toMail->ErrorInfo;
    } else {
        echo 'メールが送信されました(to)！';
    }

    unset($_POST);
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>PHPMailer test(自動返信)</title>
</head>
<body>
    <h1>PHPMailerのテスト(自動返信)</h1>
    <form action="" method="post">
        <p>
            名前: <input type="text" name="name" value="">
        </p>
        <p>
            年齢: <input type="text" name="age" value="">
        </p>
        <p>
        EMAIL: <input type="text" name="email" value="">
        </p>

        <input type="submit" value="送信">
    </form>
</body>
</html>
