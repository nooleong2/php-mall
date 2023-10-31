<?php

// DATABASE
include "../../database/database.php";

// CLASS
include "../class/product.php";
$product = new Product($conn);

$pcode = ( isset($_POST["pcode"]) && $_POST["pcode"] != "" ) ? $_POST["pcode"] : "";

if ($pcode == "") {
    $arr = ["result" => "empty_pcode"];
    die(json_encode($arr));
}

$row = $product -> getProductFromPcode($pcode);
$arr = [
    "result" => "success_get",
    "list" => $row,
];
die(json_encode($arr));

