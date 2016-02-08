<?php
/**
 * 連載情報のリスト生成
 * 次の形で追加していく↓
 * "URL" => "TITLE",
 */
$serial_list = array(
    "http://google.com" => "グーグルのサイトです。",
    "http://yahoo.co.jp" => "Yahooのサイトです。",
    "http://vdeep.net" => "vdeepのサイトです。",
    "http://localhost/php-code/php-code/serial-test/serial_test.php" => "今見てるページです。",
);

# 現在表示しているページのURL
$current_url = (empty($_SERVER["HTTPS"]) ? "http://" : "https://") .
                $_SERVER["HTTP_HOST"] .
                $_SERVER["REQUEST_URI"];

echo "今見てるページ: " . $current_url;

# リストのHTML生成
$ret_list = "<ol class='serial_list'>" . "\n";

    foreach ($serial_list as $key => $value) {
        if ($current_url === $key) {
            $ret_list .= "<li>" . $value . " <- 本記事</li>" . "\n";
        } else {
            $ret_list .= "<li><a href='" . $key . "'>" . $value . "</a></li>" . "\n";
        }
    }

$ret_list .= "</ol>\n";

# echo
echo $ret_list;
