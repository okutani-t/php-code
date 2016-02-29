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

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>Image Uploader</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.5/css/materialize.min.css">
    <link rel="stylesheet" href="style.css">
    <!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
    <![endif]-->
</head>
<body>
    <!-- header -->
    <header class="header">
        <nav>
            <div class="nav-wrapper">
                <div class="container">
                    <a href="" class="brand-logo">Image Uploader</a>
                    <ul class="right">
                        <li><a href="">
                            <i class="material-icons">close</i>
                        </a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <div class="container">

        <div class="row">
            <!-- upload button -->
            <div class="col m3 s12 upload-box">
                <form action="" method="post" enctype="multipart/form-data" id="my_form">
                    <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo h(MAX_FILE_SIZE); ?>">
                    <input type="hidden" name="delPath" value="">
                    <input type="hidden" name="dlPath" value="">
                    <div class="file-field input-field">
                        <div class="w100p btn waves-effect waves-yellow btn-large">
                            <span>Upload! <i class="mdi-content-send right"></i></span>
                            <input type="file" name="image" id="my_file">
                        </div>
                    </div>
                </form>
            </div>

            <!-- msg -->
            <?php if (isset($success)) : ?>
                <div class="col offset-m1 m7 s12 msg success card-panel teal lighten-2">
                    <h4 class="white-text center-align">
                        <?php echo h($success); ?>
                    </h4>
                </div>
            <?php endif; ?>
            <?php if (isset($error)) : ?>
                <div class="col offset-m1 m7 s12 msg error card-panel red lighten-1">
                    <h4 class="white-text center-align">
                        <?php echo h($error); ?>
                    </h4>
                </div>
            <?php endif; ?>
        </div><!-- /row -->

        <!-- img list -->
        <div class="row grid">
            <?php foreach ($images as $image) : ?>
                <!-- 画像の表示 -->
                <div class="card-box grid-item col l4 m6 s12">
                    <div class="card hoverable">
                        <div class="card-image">
                            <img class="materialboxed" src="<?php echo h($image); ?>" width="400" alt="Title">
                            <span class="card-title">Title</span>
                        </div>
                        <div class="card-content">
                            <div class="row">
                                <!-- Download btn -->
                                <div class="col s7">
                                    <a href="<?php echo h($image); ?>" class="w100p download-btn valign w100p waves-effect waves-light btn teil lighten-2"
                                        data-img-name="<?php echo h($image); ?>" download="<?php echo h(basename($image)); ?>">
                                        Download
                                    </a>
                                </div>
                                <!-- Delete btn -->
                                <div class="col s5">
                                    <div class="w100p delete-btn waves-effect waves-light btn pink lighten-1"
                                    data-img-name="<?php echo h($image); ?>">
                                    Delete
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
    </div><!-- /img list row -->

</div><!-- /container -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.5/js/materialize.min.js"></script>
<script src="https://npmcdn.com/masonry-layout@4.0/dist/masonry.pkgd.min.js"></script>
<script src="https://npmcdn.com/imagesloaded@4.1/imagesloaded.pkgd.min.js"></script>
<script>
$(function(){
    // メッセージのフェードアウト
    $('.msg').fadeOut(5000);
    // submit
    $("#my_file").on("change", function() {
        $("#my_form").submit();
    });
    // 削除
    $(".delete-btn").click(function() {
        $("[name=delPath]").val($(this).data("img-name"));
        $("#my_form").submit();
    });
    // masonry
    var $grid = $('.grid');
    $grid.imagesLoaded(function(){
        $grid.masonry({
            itemSelector: '.grid-item',
            // isFitWidth: true,
            isAnimated: true
        });
    });
});

</script>
</body>
</html>
