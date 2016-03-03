<?php
/**
 * 汎用的なfunctionをまとめたファイル
 * 利用方法: このままutils.phpを読み込ませる
 * require_once("utils.php")
 *
 * @author okutani
 * @category Util Methods
 */

/**
 * htmlspecialcharsが長いので省略したもの
 *
 * @param string $str
 * @return string htmlspecialcharsを行った結果
 */
function h($str)
{
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}
/**
 * リダイレクト処理
 * 現在表示してるパスに飛ぶ
 */
function redirect()
{
    header("Location: " .
    (empty($_SERVER["HTTPS"]) ? "http://" : "https://") .
    $_SERVER["HTTP_HOST"] .
    $_SERVER["REQUEST_URI"]);
    exit;
}
