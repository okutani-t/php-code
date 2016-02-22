<?php
/**
 * 連載情報のリスト生成
 * 次の形で追加していく↓
 * "URL" => "TITLE",
 */
$series_list = array(
    "http://google.com" => "グーグルのサイトです。グーグルのサイトです。グーグルのサイトです。グーグルのサイトです。",
    "http://yahoo.co.jp" => "Yahooのサイトです。",
    "http://vdeep.net" => "Vdeepのサイトです。vdeepのサイトです。vdeepのサイトです。vdeepのサイトです。vdeepのサイトです。vdeepのサイトです。",
    "http://localhost/php-code/php-code/series-post-test/series_post_test.php" => "今見てるページです。",
);

# 現在表示しているページのURL
$current_url = (empty($_SERVER["HTTPS"]) ? "http://" : "https://") .
                $_SERVER["HTTP_HOST"] .
                $_SERVER["REQUEST_URI"];

echo "今見てるページ: " . $current_url;

# リストのHTML生成
$ret_list = "<ol class='series_list'>" . "\n";

    foreach ($series_list as $key => $value) {
        if ($current_url === $key) {
            $ret_list .= "<li>" . $value . " <- 本記事</li>" . "\n";
        } else {
            $ret_list .= "<li><a href='" . $key . "'>" . $value . "</a></li>" . "\n";
        }
    }

$ret_list .= "</ol>\n";

# echo
// echo $ret_list;

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>series post test</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/3.0.3/normalize.css">
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <div class="container">
            <?php echo $ret_list; ?>
        </div>
    </body>
</html>
