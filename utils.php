<?php
/**
 * 汎用的なfunctionをまとめたファイル
 * 利用方法: このままutils.phpを読み込ませる
 * require_once("utils.php")
 *
 * @author okutani
 * @category Util Methods
 */
/******************************
 * timestamp操作
 ******************************/
/**
 * timestamp整形Ymd
 *
 * @param timestamp $ts
 * @return string Y-m-d形式
 */
function toDateYmd($ts)
{
    // 数字かチェック
    if (!ctype_digit($ts)) {
        trigger_error("please input ts int type", E_USER_ERROR);
    }

    return date('Y-m-d', $ts);
}

/**
 * timestamp整形Ymdhi
 *
 * @param timestamp $ts
 * @return string Y-m-d H:i形式
 */
function toDateYmdHi($ts)
{
    // 数字かチェック
    if (!ctype_digit($ts)) {
        trigger_error("please input ts int type", E_USER_ERROR);
    }

    return date('Y-m-d H:i', $ts);
}

/**
 * 文字列で日付と時間を受け取ってTimeStampを返す
 *
 * @param string $ymd 2015-12-12の形で受け取る
 * @param string $hi 12:30の形で受け取る
 * @return timestamp
 */
function toTimeStamp($ymd, $hi)
{
    // 文字列かチェック
    if (!is_string($ymd) || !is_string($hi)) {
        trigger_error("please input ymd or hi int type", E_USER_ERROR);
    }

    // 「-」と「/」に対応
    $ymdPtn = preg_match('/-/', $ymd) ? "-" : "/";

    $ymdArr = explode($ymdPtn, $ymd);
    $hiArr  = explode(":", $hi);

    return mktime($hiArr[0], $hiArr[1], 0, $ymdArr[1], $ymdArr[2], $ymdArr[0]);
}

/**
 * 基準日からの経過日数を取得する
 * ※2038年問題をクリアしていない？
 *
 * @param  string $baseDate   基準になる日付
 * @param  string $targetDate 対象の日付
 * @return string 経過日数
 */
function dayDiff($baseDate, $targetDate)
{
    // 日付をUNIXタイムスタンプに変換
    $baseDate   = strtotime($baseDate);
    $targetDate = strtotime($targetDate);

    // 何秒離れているかを計算
    $secondDiff = abs($targetDate - $baseDate);

    // 戻り値
    return $secondDiff / (60 * 60 * 24);
}

/******************************
 * 文字列・配列操作
 ******************************/
/**
 * {0,0,0}の形の文字列を配列に変換する関数
 *
 * @param string $str {0,0,0}の形式
 * @return array
 */
function bracesStrToAry($str)
{
    if (!is_string($str)) return $str;
    $str = preg_replace('/\A\{|( |　)|\}\z/u', '', $str);
    $arr = explode(',', $str);
    return $arr;
}

/**
 * 配列を{0,0,0}のような形式のstringに変換
 *
 * @param array $arr
 * @return string {0,0,0}の形式
 */
function toBraces($arr)
{
    if (!is_array($arr)) return $arr;
    $str = "{";
    for ($i = 0; $i < count($arr); $i++) {
        $str .= $arr[$i];
        // 最後の値以外カンマをつける
        if ($i != count($arr) - 1) {
            $str .= ",";
        }
    }
    return $str .= "}";
}

/**
 * 0-1かtrue-falseを日本語で「ありなし」に変換
 *
 * @param int|bool $flag
 * @return string
 */
function chkFlgToJa($flag=0)
{
    if ($flag === 0 || $flag === "0" || $flag == false) {
        return "なし";
    } elseif ($flag === 1 || $flag === "1" || $flag == true) {
        return "あり";
    } else {
        trigger_error("please 0-1 or true-false...", E_USER_ERROR);
    }
}

/**
 * 全ての配列の要素に同じ値を乗算する
 *
 * @param array $arr
 * @return string {0,0,0}の形式
 */
function multEachAry($arr, $operand)
{
    $mult = function($arr, $operand) {
        return $arr * $operand;
    };
    $ret = array_map($mult, $arr, array_fill(0, count($arr), $operand));
    return $ret;
}
// 全ての配列の要素に同じ値を乗算する -> ラムダ関数版
// $multEachAry2 = function($arr, $operand){
//     $mult = function($arr, $operand) {
//         return $arr * $operand;
//     };
//     $ret = array_map($mult, $arr, array_fill(0, count($arr), $operand));
//     return $ret;
// };

/**
 * 配列内の空文字を取り除き、添字を振り直す
 *
 * @param array $arr
 * @return array
 */
function rmEmptyStrFromAry($arr)
{
    //配列の中の空要素を削除
    $arr = array_filter($arr, "strlen");
    //添字を振り直す
    return array_values($arr);
}

/**
 * 配列の深さを調べる
 *
 * @param  array $arr
 * @return int 配列の深さ
 */
function array_depth($arr, $depth=0){
    if( !is_array($arr)){
        return $depth;
    } else {
        $depth++;
        $tmp = array();
        foreach($arr as $value){
            $tmp[] = array_depth($value, $depth);
        }
        return max($tmp);
    }
}

/******************************
 * ディレクトリ・ファイル操作
 ******************************/
/**
 * ディレクトリの生成
 * 指定したパスの途中にあるディレクトリも同時に生成される
 *
 * @param string args ディレクトリのパス
 */
function createDirs(/*args*/)
{
    foreach (func_get_args() as $path) {
        // ディレクトリが存在していなければ生成
        if (!file_exists($path)) {
            // パーミッションの制限を解除
            umask(0);
            // ディレクトリ生成
            mkdir($path, '0777', true);
        }
    }
}

/**
 * ファイルの生成
 * 複数のパスを渡せる
 *
 * @param string args ファイルまでのパス
 */
function createFiles(/*args*/)
{
    foreach (func_get_args() as $file) {
        // 存在していなければ生成
        if (!file_exists($file)) {
            // 生成
            touch($file);
            // パーミッションの設定
            chmod($file, 0777);
        }
    }
}

/**
 * txtファイルを読み込み、tab等で句切られた文字を配列にして返す
 * 返り値は二次元配列なので受け取り側はlistを使う
 *
 * @param string $delimiter tab等の区切り文字
 * @param string $file_path ファイルまでのパス
 * @return array arrayの2次元配列
 */
function fileDelimit($delimiter="", $file_path=false)
{
    $lines = file($file_path);
    // エラーチェック
    if ($lines === false  ||
        $delimiter === "" ||
        $file_path === false) {
            trigger_error("failed file delimit...", E_USER_ERROR);
    }

    for ($i = 0; $i < count($lines); $i++) {
        list($lAry[], $rAry[]) = explode($delimiter, $lines[$i]);
    }

    return array($lAry, $rAry);
}

/******************************
 * 改行の処理
 ******************************/
/**
 * \nを<br>に、<br>を\nに置換する
 *
 * @param string $str
 * @return string $str
 */
function orgNl2br($str)
{
    // 末尾の改行や空白を取り除く
    $str = rtrim($str);
    // 改行のパターン
    $linefeed = array("\r\n", "\n", "\r");
    if (strpos($str, "\n") !== false || strpos( $str, "\r" ) !== false) {
        return str_replace($linefeed, "<br>", $str);
    } elseif (strpos($str, "<br>") !== false) {
        return str_replace("<br>", "\n", $str);
    }
    return $str;
}

/******************************
 * CSRF対策
 ******************************/
/**
 * 使用例
 * if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 *     _validateToken();
 * } else {
 *     _createToken();
 * }
 *
 * <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
 */
/**
 * トークンの生成
 * session_start();しておく必要がある
 */
function _createToken()
{
    if (!isset($_SESSION['token'])) {
        $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(16));
    }
}

/**
 * トークンのチェック
 * session_start();しておく必要がある
 */
function _validateToken()
{
    if (
    !isset($_SESSION['token']) ||
    !isset($_POST['token']) ||
    $_SESSION['token'] !== $_POST['token']
    ) {
        throw new Exception('invalid token!');
    } else {
        // echo "token check is ok";
    }
}

/******************************
 * フォームから送られた値の型チェック系
 ******************************/
/**
 * ひらがなかどうかチェック
 *
 * @param  string $str チェックする文字列
 * @return bool ひらがなならtrue
 */
function isHiragana($str)
{
    // 文字列かどうか
    if (!is_string($str)) {
        throw new Exception('please input hiragana string type...');
    }

    // ひらがなならtrueを返す
    return (bool)preg_match('/\A[ぁ-ん 　]+\z/u', $str);
}

/**
 * カタカナかどうかチェック
 * 半角でも全角でも通す
 *
 * @param string $str チェックする文字列
 * @param bool $isKana カタカナならtrue
 */
function isKatakana($str)
{
    $isFull = false;
    $isHalf = false;

    // 文字列かどうか
    if (!is_string($str)) {
        throw new Exception('please input katakana string type...');
    }

    // 全角カタカナならtrueをセット
    if (preg_match('/\A[ァ-ヾ 　]+\z/u', $str)) {
        $isFull = true;
    }

    // 半角カタカナならtrueをセット
    if (preg_match('/\A[ｦ-ﾟｰ 　]+\z/u', $str)) {
        $isHalf = true;
    }

    // 全角もしくは半角ならtrueを返す
    return ($isFull || $isHalf);
}

/**
 * 電話番号かどうかチェック
 *
 * @param  string $tel チェックする電話番号
 * @return bool 電話番号の形ならtrue
 */
function isTel($tel)
{
    //半角に変換
    $tel = mb_convert_kana($tel, 'a', 'utf-8');
    //半角または全角のハイフンを取り除く
    $tel = mb_ereg_replace("-",  "", $tel);
    $tel = mb_ereg_replace("‐",  "", $tel);
    $tel = mb_ereg_replace("―",  "", $tel);
    $tel = mb_ereg_replace("ー", "", $tel);

    // 電話番号のパターン
    $ptn = array(
        '0[0-9]{9}',
        '0[7-9]{1}0[0-9]{8}'
    );

    // 電話番号のパターンにマッチすればtrueを返す
    return (bool)preg_match('/\A'.implode('\z|\A', $ptn).'\z/', $tel);
}

/**
 * 郵便番号かどうかチェック
 *
 * @param  string $zip チェックする郵便番号(000-0000の形)
 * @return bool 郵便番号の形ならtrue
 */
function isZipCode($zip)
{
    // 文字列かどうか
    if (!is_string($zip)) {
        throw new Exception('please input zip string type...');
    }

    // 半角に変換
    $zip = mb_convert_kana($zip, 'a', 'utf-8');

    // 郵便番号の形かチェック
    return (bool)preg_match('/\A\d{3}[ー―‐-]?\d{4}\z/u', $zip);
}

/**
 * メールアドレスかどうかチェック
 * 参考: http://qiita.com/ryounagaoka/items/dc9fe731d0fa6f8f9daa
 *
 * @param  string $email チェックする電話番号
 * @return bool 電話番号の形ならtrue
 */
function isEmail($email)
{
    // 文字列かどうか
    if (!is_string($email)) {
        throw new Exception('please input email string type...');
    }

    // メールアドレスのパターン
    $ptn = '/\A[\p{L}0-9!#$%&\'*+\/=?^_`{|}~-]+(?:\.[\p{L}0-9!#$'.
           '%&\'*+\/=?^_`{|}~-]+)*@(?:[_\p{L}0-9][-_\p{L}0-9]*\.'.
           ')*(?:[\p{L}0-9][-\p{L}0-9]{0,62})\.(?:(?:[a-z]{2}\.)?[a-z]{2,})\z/ui';

    // メールアドレスの形式かチェック
    return (bool)preg_match($ptn, $email);
}

/******************************
 * どこでも使うやつ
 ******************************/
/**
 * issetの処理を拡張したもの
 * 主にPOSTで受け取った値の処理に使う
 *
 * @param mixed $chkVal
 * @param mixed $setVal
 * @return mixed 比較した値のどちらか
 */
function orgIsset($chkVal, $setVal="")
{
    if (isset($chkVal) && !empty($chkVal) || $chkVal === "0") {
        return $chkVal;
    } else {
        return $setVal;
    }
}

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
 * var_dumpのデバッグを見やすく表示
 *
 * @param mixed 複数の引数を取れる
 */
function d()
{
    echo '<pre style="background:#fff;color:#333;border:1px solid #ccc;'.
         'margin:2px;padding:4px;font-family:monospace;font-size:12px;line-height:18px">';
    foreach (func_get_args() as $value) {
        var_dump($value);
    }
    echo '</pre>';
}

/**
 * デバッグモードの切り替え
 */
function isDebug($flag=true)
{
    define('DEBUG', $flag);
    define('DISPLAY_ERRORS', DEBUG ? 1 : 0); // エラーを表示するか否か(DEBUG==TRUEのとき、エラー表示モード)
    ini_set('display_errors', DISPLAY_ERRORS);      // エラーがあるとき、表示する設定
    error_reporting(E_ALL ^ E_NOTICE);              // NOTICE エラー以外の全てのエラーを表示する。
}

/**
 * PHPの変数をjsonに変換
 *
 * @param mixed 変数
 * @return mixed $value json_encodeの結果
 */
function jsonEncode($value)
{
    return json_encode($value, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
}

// テスト場所

// echo array_depth(array(array(5),array(4)));
