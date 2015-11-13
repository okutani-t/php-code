<?php
/**
 * xampp(ローカル環境)でmailのテスト通信
 * 『php.ini』と『sendmail.ini』を予め書き換えておく
 * ブログ記事書いたら追記
 */

// 宛先メールアドレス
$to      = 'info@sample.com';
// メールタイトル
$subject = 'メール送信のテストです';
// 本文
$body    = 'localhostから送ってみたよ。届いたかな';

if (mb_send_mail($to, $subject, $body)) {
    echo '送信完了！';
} else {
    echo '送信失敗...';
}
