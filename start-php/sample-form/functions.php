<?php

// 汎用的な関数をまとめたファイル

// DB接続
function connectDb() {
    try {
        return new PDO(DSN, DB_USER, DB_PASSWORD);
    } catch (PDOException $e) {
        echo $e->getMessage();
        exit;
    }
}

// エスケープ処理
function h($s) {
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

// CSRF対策
// セッションにトークンがセットされていなかったらセットする

function setToken() {
    if(!isset($_SESSION['token'])) {
        $_SESSION['token'] = sha1(uniqid(mt_rand(), true));
    }
}

// トークンが正しいか確認する
function checkToken() {
    if(empty($_POST['token']) || $_POST['token'] != $_SESSION['token']) {
        echo $_POST['token'];
        echo '<br>';
        echo '<br>';
        echo $_SESSION['token'];
        echo '<br>';
        echo '不正な処理です';
        exit;
    }
}
