<?php

// DATABASE
include "../assets/database/database.php";

// CLASS
include "../assets/admin/class/product.php";
$product = new Product($conn);

$id = ( isset($_POST["id"]) && $_POST["id"] != "" ) ? $_POST["id"] : "";
$pcode = ( isset($_POST["pcode"]) && $_POST["pcode"] != "" ) ? $_POST["pcode"] : "";
$cnt = ( isset($_POST["cnt"]) && $_POST["cnt"] != "" && is_numeric($_POST["cnt"]) ) ? $_POST["cnt"] : "";

if ($id == "" || $pcode == "" || $cnt == "") {
    $arr = ["result" => "empty_info"];
    die(json_encode($arr));
}

$arr = [
    "id" => $id,
    "pcode" => $pcode,
    "cnt" => $cnt,
];
$product -> addCartProduct($arr);
$arr = ["result" => "success"];
die(json_encode($arr));
