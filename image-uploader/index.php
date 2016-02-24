<?php

session_start();
ini_set("display_errors", 1);
define("MAX_FILE_SIZE", 10 * 1024 * 1024); // 3MB
define("RESIZE_MAX_WIDTH", 3000);
define("IMAGES_DIR", __DIR__ . "/images");

if (!function_exists("imagecreatetruecolor")) {
    echo "GD not installed!";
    exit;
}

function h($s) {
    return htmlspecialchars($s, ENT_QUOTES, "UTF-8");
}

require "ImageUploader.php";

$uploader = new \MyApp\ImageUploader();

// delete
if ($_SERVER["REQUEST_METHOD"] === "POST" && $_POST["action"] === "imgDel") {
    $uploader->delete();
    // redirect
    header("Location: " .
    (empty($_SERVER["HTTPS"]) ? "http://" : "https://") .
    $_SERVER["HTTP_HOST"] .
    $_SERVER["REQUEST_URI"]);
    exit;
}
// upload
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $uploader->upload();
}

// サクセス・エラー文の取得
list($success, $error) = $uploader->getResults();
// 画像ファイルパスの取得
$images = $uploader->getImages();

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>Image Uploader</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="btn">
        Upload!
        <form action="" method="post" enctype="multipart/form-data" id="my_form">
            <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo h(MAX_FILE_SIZE); ?>">
            <input type="hidden" name="action" value="">
            <input type="file" name="image" id="my_file">
        </form>
    </div>

    <?php if (isset($success)) : ?>
        <div class="msg success"><?php echo h($success); ?></div>
    <?php endif; ?>
    <?php if (isset($error)) : ?>
        <div class="msg error"><?php echo h($error); ?></div>
    <?php endif; ?>
    <ul>
        <?php foreach ($images as $image) : ?>
            <!-- 画像の表示 -->
            <li>
                <a href="<?php echo h(basename(IMAGES_DIR)) . "/" . basename($image); ?>">
                    <img src="<?php echo h($image); ?>" width="300">
                </a>
            </li>

            <!-- 画像までのフルパス -->
            <li>
                <?php echo dirname((empty($_SERVER["HTTPS"]) ? "http://" : "https://") .
                $_SERVER["HTTP_HOST"] .
                $_SERVER["REQUEST_URI"]) . "/" .
                $image; ?>
            </li>

            <button type="button" name="delete" data-img-name="<?php echo h($image); ?>">delete</button><br><br>
        <?php endforeach ?>
    </ul>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>
    $(function(){
        $('.msg').fadeOut(3000);
        $("#my_file").on("change", function() {
            $("#my_form").submit();
        });
        $("[name=delete]").click(function(){
            alert($(this).data("img-name"));
        });
    });
    </script>
</body>
</html>
