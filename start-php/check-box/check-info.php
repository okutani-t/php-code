<?php

$checkbox = $_REQUEST["chk"];
echo "あなたが選んだのは...";
echo "<br><br>";
for($i = 0;$i < count($checkbox);$i++){
    echo ($i+1).". ".$checkbox[$i];
    echo "<br>";
}
?>
