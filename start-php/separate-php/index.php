<?php
// getでつけてあげると切り替わる
// ?type=main2 でmain2.phpが表示

$type = "";

if (isset($_GET["type"])) {
    $type = $_GET["type"];
}

require_once("header.php");

if ($type == "" || $type == "main1") {
    require_once("main.php");
} elseif ($type == "main2") {
    require_once("main2.php");
} else {
    echo "error!";
}

require_once("footer.php");
