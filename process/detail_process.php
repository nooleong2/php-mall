<?php

// DATABASE
include "../assets/database/database.php";

// CLASS
include "../assets/admin/class/product.php";
$product = new Product($conn);

$id = ( isset($_POST["id"]) && $_POST["id"] != "" ) ? $_POST["id"] : "";
$pcode = ( isset($_POST["pcode"]) && $_POST["pcode"] != "" ) ? $_POST["pcode"] : "";
$cnt = ( isset($_POST["cnt"]) && $_POST["cnt"] != "" && is_numeric($_POST["cnt"]) ) ? $_POST["cnt"] : "";
$mode = ( isset($_POST["mode"]) && $_POST["mode"] != "" ) ? $_POST["mode"] : "";


if ($mode == "") {
    $arr = ["result" => "empty_mode"];
    die(json_encode($arr));
}

if ($mode == "cart_add") {

    if ($id == "") {
        $arr = ["result" => "empty_session_id"];
        die(json_encode($arr));
    }

    if ($pcode == "" || $cnt == "") {
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

} else if ($mode == "order") {

    $order_uid = ( isset($_POST["order_uid"]) && $_POST["order_uid"] != "" ) ? $_POST["order_uid"] : "";
    $m_id = ( isset($_POST["m_id"]) && $_POST["m_id"] != "" ) ? $_POST["m_id"] : "";
    $m_name = ( isset($_POST["m_name"]) && $_POST["m_name"] != "" ) ? $_POST["m_name"] : "";
    $m_phone = ( isset($_POST["m_phone"]) && $_POST["m_phone"] != "" ) ? $_POST["m_phone"] : "";
    $m_email = ( isset($_POST["m_email"]) && $_POST["m_email"] != "" ) ? $_POST["m_email"] : "";
    $m_zipcode = ( isset($_POST["m_zipcode"]) && $_POST["m_zipcode"] != "" ) ? $_POST["m_zipcode"] : "";
    $m_addr = ( isset($_POST["m_addr"]) && $_POST["m_addr"] != "" ) ? $_POST["m_addr"] : "";
    $p_name = ( isset($_POST["p_name"]) && $_POST["p_name"] != "" ) ? $_POST["p_name"] : "";
    $p_code = ( isset($_POST["p_code"]) && $_POST["p_code"] != "" ) ? $_POST["p_code"] : "";
    $p_cnt = ( isset($_POST["p_cnt"]) && $_POST["p_cnt"] != "" ) ? $_POST["p_cnt"] : "";
    $p_one_price = ( isset($_POST["p_one_price"]) && $_POST["p_one_price"] != "" ) ? $_POST["p_one_price"] : "";
    $p_total_price = ( isset($_POST["p_total_price"]) && $_POST["p_total_price"] != "" ) ? $_POST["p_total_price"] : "";

    $arr = [
        "order_uid" => $order_uid,
        "m_id" => $m_id,
        "m_name" => $m_name,
        "m_phone" => $m_phone,
        "m_email" => $m_email,
        "m_zipcode" => $m_zipcode,
        "m_addr" => $m_addr,
        "p_name" => $p_name,
        "p_code" => $p_code,
        "p_cnt" => $p_cnt,
        "p_one_price" => $p_one_price,
        "p_total_price" => $p_total_price,
    ];

    $product -> order($arr);
    
    $arr = ["result" => "success"];
    die(json_encode($arr));
}

