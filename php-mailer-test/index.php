<?php
/**
 * PHPMailerのテスト
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
    $subject = 'SOFからお問い合わせがありました';
    $body    = '名前: ' . $_POST["name"] .
               "\n年齢: " . $_POST["age"] .
               "\nメールアドレス: " . $_POST["email"];

    // タイムゾーン設定
    date_default_timezone_set('Asia/Tokyo');

    $mail = new PHPMailer;

    /****************************
     * SMTPの設定
     * SMTPサーバのアドレスはphp.iniに設定してあればすべて設定不要
     ****************************/
    /*
    $mail->isSMTP();
    $mail->Host = 'smtp1.example.com;smtp2.example.com';
    // Gmailの場合
    // $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    // Gmailの場合はGmailのアドレスとパスワード
    $mail->Username = 'user@example.com';
    $mail->Password = 'hogemoge537';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;
    */
    // 文字エンコーディングの設定
    $mail->CharSet = "UTF-8";    // 文字セット(デフォルトは'ISO-8859-1')
    $mail->Encoding = "base64";  // エンコーディング(デフォルトは'8bit')

    // 送信先やCC等の設定
    $mail->setFrom($from);
    foreach ($to as $value) {
        $mail->addAddress($value);
    }
    // $mail->addReplyTo($reply);
    // $mail->addCC('cc@example.com');
    // $mail->addBCC('bcc@example.com');

    // 画像添付・HTMLメールなど
    // $mail->addAttachment('/var/tmp/file.tar.gz');
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');
    // $mail->isHTML(true);
    // テキストメールの場合
    $mail->isHTML(false);

    // 件名
    $mail->Subject = $subject;
    // 本文
    $mail->Body    = $body;

    if (!$mail->send()) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo 'メールが送信されました！';
    }

    unset($_POST);
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>PHPMailer test</title>
</head>
<body>
    <h1>PHPMailerのテスト</h1>
    <form action="" method="post">
        <p>
            名前: <input type="text" name="name" value="">
        </p>
        <p>
            年齢: <input type="text" name="age" value="">
        </p>

        <input type="submit" value="送信">
    </form>
</body>
</html>
