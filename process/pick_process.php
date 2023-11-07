<?php

// DATABASE
include "../assets/database/database.php";

// CLASS
include "../assets/admin/class/product.php";
$product = new Product($conn);
$idx = ( isset($_POST["idx"]) && $_POST["idx"] != "" && is_numeric($_POST["idx"]) ) ? $_POST["idx"] : "";
$id = ( isset($_POST["id"]) && $_POST["id"] != "" ) ? $_POST["id"] : "";
$pcode = ( isset($_POST["pcode"]) && $_POST["pcode"] != "" ) ? $_POST["pcode"] : "";
$ccode = ( isset($_POST["ccode"]) && $_POST["ccode"] != "" ) ? $_POST["ccode"] : "";
$mode = ( isset($_POST["mode"]) && $_POST["mode"] != "" ) ? $_POST["mode"] : "";

if ($mode == "add") {
    if ($id == "") {
        $arr = ["result" => "empty_session_id"];
        die(json_encode($arr));
    }

    if ($pcode == "") {
        $arr = ["result" => "empty_info"];
        die(json_encode($arr));
    }

    $rows = $product -> getPickList($id);
    foreach ($rows as $row) {
        if ($pcode == $row["pcode"]) {
            $arr = ["result" => "already_pick"];
            die(json_encode($arr));
        }
    }

    $arr = [
        "id" => $id,
        "pcode" => $pcode,
        "ccode" => $ccode,
    ];
    
    $product -> pickAdd($arr);
    $arr = ["result" => "success"];
    die(json_encode($arr));

} else if ($mode == "delete") {
    if ($pcode == "") {
        $arr = ["result" => "empty_pcode"];
        die(json_encode($arr));
    }

    $product -> pickDelete($pcode);
    $arr = ["result" => "success"];
    die(json_encode($arr));
}


