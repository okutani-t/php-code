<?php
require_once "vendor/autoload.php";

use Ronin\Blade;
$blade = Blade::make(__DIR__ . '/views', __DIR__ . '/cache');
echo $blade->make("top"); // => Illuminate\View\Factory

?>
