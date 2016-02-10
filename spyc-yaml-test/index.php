<?php

// https://github.com/mustangostang/spyc/

require_once "spyc.php";
$Data = Spyc::YAMLLoad('spyc.yaml');
$Users = Spyc::YAMLLoad('users.yaml');

// var_dump($Data);

var_dump($Users);

echo $Users["users"][0]["name"];
