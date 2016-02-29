<?php

session_start();
ini_set("display_errors", 1);
define("MAX_FILE_SIZE", 3 * 1024 * 1024); // 3MB
define("RESIZE_MAX_WIDTH", 2000);
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
if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST["delPath"])) {
    try {
        $isDelImg = unlink(IMAGES_DIR . "/" . basename($_POST["delPath"]));
        if ($isDelImg) {
            $_SESSION["success"] = "Delete Done!";
        } else {
            throw new \Exception("Image can't be deleted!");
        }
    } catch (\Exception $e) {
        $_SESSION["error"] = $e->getMessage();
    }
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
