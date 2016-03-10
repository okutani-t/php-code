<?php

session_start();

// エラー表示
ini_set("display_errors", 1);

// アップロードできるファイル容量の上限
define("MAX_FILE_SIZE", 3 * 1024 * 1024); // 3MB

// 自動リサイズする横幅の値
// これ以上大きかったら設定した値にリサイズされる
define("RESIZE_MAX_WIDTH", 2000);

// サムネイル画像の横幅
define("THUMB_MAX_WIDTH", 400);


///////// ここまで /////////

/**
 * 画像までのパス
 * GETの値が無い・一致しない＆ディレクトリが存在しない場合、最新年月の画像パスを表示
 * 画像がimagesに一枚もなければimagesまでのディレクトリを定義
 */
// 現在の年月を含んだ画像パス
define("IMAGES_DIR_YM_NOW", __DIR__ . "/images/" . date("Y-m", time()));

// 現在指定している年月とそのディレクトリを定義
if (isset($_GET["ym"]) &&
    preg_match("/\A[0-9]{4}-[0-9]{2}\z/", $_GET["ym"]) &&
    file_exists(__DIR__ . "/images/" . $_GET["ym"])) {
    define("CURRENT_YM", $_GET["ym"]);
    define("CURRENT_IMAGES_DIR", __DIR__ . "/images/" . $_GET["ym"]);
} elseif(file_exists(IMAGES_DIR_YM_NOW)) { // 上記に一致しなければ最新のディレクトリを開く
    define("CURRENT_YM", "");
    define("CURRENT_IMAGES_DIR", IMAGES_DIR_YM_NOW);
} else { // 画像が一枚もない場合
    define("CURRENT_YM", "");
    define("CURRENT_IMAGES_DIR", __DIR__ . "/images");
}
