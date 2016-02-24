<?php

// https://github.com/mustangostang/spyc/

require_once "spyc.php";
// $Data = Spyc::YAMLLoad('spyc.yaml');
$Data = Spyc::YAMLLoad('users.yaml');
$Users = $Data["users"];
$Admin = $Data["admin"];

// var_dump($Users);
// var_dump($Admin);

echo "<br>【users】<br>";

foreach ($Users as $key => $value) {
    echo "name" . $value["id"] . ": " . $value["name"] . "<br>";
    echo "email" . $value["id"] . ": " . $value["email"] . "<br><br>";
}

echo "<br>【admin】<br>";

echo "name: " . $Admin["name"] . "<br>";
echo "email: " . $Admin["email"];
