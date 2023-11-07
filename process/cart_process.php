<?php

// DATABASE
include "../assets/database/database.php";

// CLASS
include "../assets/admin/class/product.php";
$product = new Product($conn);

$idx = ( isset($_POST["idx"]) && $_POST["idx"] != "" && is_numeric($_POST["idx"]) ) ? $_POST["idx"] : "";
$mode = ( isset($_POST["mode"]) && $_POST["mode"] != "" ) ? $_POST["mode"] : "";

if ($mode == "delete") {
    if ($idx == "") {
        $arr = ["result" => "empty_idx"];
        die(json_encode($arr));
    }
    
    $product -> deleteCartProduct($idx);
    $arr = ["result" => "success"];
    die(json_encode($arr));
} else if ($mode == "order") {
    
    $length = ( isset($_POST["length"]) && $_POST["length"] != "" && is_numeric($_POST["length"]) ) ? $_POST["length"] : "";
    $cartArr = [];
    for ($i = 0; $i < $length; $i++) {
        $order_uid = ( isset($_POST["order_uid"]) && $_POST["order_uid"] != "" ) ? $_POST["order_uid"] : "";
        $m_id = ( isset($_POST["m_id"]) && $_POST["m_id"] != "" ) ? $_POST["m_id"] : "";
        $m_name = ( isset($_POST["m_name"]) && $_POST["m_name"] != "" ) ? $_POST["m_name"] : "";
        $m_phone = ( isset($_POST["m_phone"]) && $_POST["m_phone"] != "" ) ? $_POST["m_phone"] : "";
        $m_email = ( isset($_POST["m_email"]) && $_POST["m_email"] != "" ) ? $_POST["m_email"] : "";
        $m_zipcode = ( isset($_POST["m_zipcode"]) && $_POST["m_zipcode"] != "" ) ? $_POST["m_zipcode"] : "";
        $m_addr = ( isset($_POST["m_addr"]) && $_POST["m_addr"] != "" ) ? $_POST["m_addr"] : "";
        $p_total_price = ( isset($_POST["p_total_price"]) && $_POST["p_total_price"] != "" ) ? $_POST["p_total_price"] : "";

        $p_name = ( isset($_POST["p_name" . $i . ""]) && $_POST["p_name" . $i . ""] != "" ) ? $_POST["p_name" . $i . ""] : "";
        $p_code = ( isset($_POST["p_code" . $i . ""]) && $_POST["p_code" . $i . ""] != "" ) ? $_POST["p_code" . $i . ""] : "";
        $p_cnt = ( isset($_POST["p_cnt" . $i . ""]) && $_POST["p_cnt" . $i . ""] != "" ) ? $_POST["p_cnt" . $i . ""] : "";
        $p_one_price = ( isset($_POST["p_one_price" . $i . ""]) && $_POST["p_one_price" . $i . ""] != "" ) ? $_POST["p_one_price" . $i . ""] : "";

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

        array_push($cartArr, $arr);
    }

    $product -> cartOrder($cartArr);
    
    $arr = ["result" => "success"];
    die(json_encode($arr));
    
}

