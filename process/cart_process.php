<?php

// DATABASE
include "../assets/database/database.php";

// CLASS
include "../assets/admin/class/product.php";
$product = new Product($conn);

$idx = ( isset($_POST["idx"]) && $_POST["idx"] != "" && is_numeric($_POST["idx"]) ) ? $_POST["idx"] : "";

if ($idx == "") {
    $arr = ["result" => "empty_idx"];
    die(json_encode($arr));
}

$product -> deleteCartProduct($idx);
$arr = ["result" => "success"];
die(json_encode($arr));
