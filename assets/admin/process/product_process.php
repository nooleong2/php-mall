<?php

// SESSION
include "../inc/session.php";

// DATABASE
include "../../database/database.php";

// CLASS
include "../class/product.php";
include "../class/category_manager.php";
$product = new Product($conn);
$cm = new CategoryManager($conn);

$mode = ( isset($_POST["mode"]) && $_POST["mode"] != "" ) ? $_POST["mode"] : "";
$pcode = ( isset($_POST["pcode"]) && $_POST["pcode"] != "" ) ? $_POST["pcode"] : "";

// 상품 정보
$idx = ( isset($_POST["idx"]) && $_POST["idx"] != "" && is_numeric($_POST["idx"]) ) ? $_POST["idx"] : "";
$ccode = ( isset($_POST["ccode"]) && $_POST["ccode"] != "" ) ? $_POST["ccode"] : "";
$country_kr = ( isset($_POST["country_kr"]) && $_POST["country_kr"] != "" ) ? $_POST["country_kr"] : "";
$country_en = ( isset($_POST["country_en"]) && $_POST["country_en"] != "" ) ? $_POST["country_en"] : "";
$price = ( isset($_POST["price"]) && $_POST["price"] != "" && is_numeric($_POST["price"]) ) ? $_POST["price"] : "";
$cnt = ( isset($_POST["cnt"]) && $_POST["cnt"] != "" && is_numeric($_POST["cnt"]) ) ? $_POST["cnt"] : "";
$name = ( isset($_POST["name"]) && $_POST["name"] != "" ) ? $_POST["name"] : "";
$bio = ( isset($_POST["bio"]) && $_POST["bio"] != "" ) ? $_POST["bio"] : "";
$photo = ( isset($_FILES["photo"]) && $_FILES["photo"] != "" ) ? $_FILES["photo"] : "";

// 모드 빈 값 겁증
if ($mode == "") {
    $arr = ["result" => "empty_mode"];
    die(json_encode($arr));
}

// 모드 기능

if ($mode == "get") {
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

} else {
    if ($ccode == "") {
        $arr = ["result" => "empty_ccode"];
        die(json_encode($arr));
    } else if ($pcode == "") {
        $arr = ["result" => "empty_pcode"];
        die(json_encode($arr));
    } else if ($country_kr == "") {
        $arr = ["result" => "empty_country_kr"];
        die(json_encode($arr));
    } else if ($country_en == "") {
        $arr = ["result" => "empty_country_en"];
        die(json_encode($arr));
    } else if ($price == "") {
        $arr = ["result" => "empty_price"];
        die(json_encode($arr));
    } else if ($cnt == "") {
        $arr = ["result" => "empty_cnt"];
        die(json_encode($arr));
    } else if ($name == "") {
        $arr = ["result" => "empty_name"];
        die(json_encode($arr));
    }

    if ($mode == "add") {

        // 상품이미지는 공통 처리가 아닌 부분 처리 처음 등록할때는 필수롤 들어가야하기 때문
        if ($photo == "") {
            $arr = ["result" => "empty_photo"];
            die(json_encode($arr));
        }

        // 대소문자 구분 없이 :: 데이터베이스에서는 대소문자를 구분하지 않기 때문에
        if ( !empty($row) && strcasecmp($row["pcode"], $pcode) == 0 ) {
            $arr = ["result" => "already_pcode"];
            die(json_encode($arr));
        }

        // 상품 코드 자리 수
        if (strlen($pcode) > 20) {
            $arr = ["result" => "over_string"];
            die(json_encode($arr));
        }

        // 이미지 서버 폴더 저장 및 이미지 네이밍 변경
        $photo_name = "";
        $change_photo_name = "";
        $crt_datetime = date("Ymd" . time()); // 이미지명 중복 방지
        if ( !empty($photo) ) {

            // 이미지 확장자 검증
            list(, $etc) = explode(".", $photo["name"]);
            if ( !($etc == "png" || $etc == "PNG" || $etc == "jpg" || $etc == "JPG") ) {
                $arr = ["result" => "wrong_type"];
                die(json_encode($arr));
            }
            
            // 파일 서버 업로드 기존 파일명, 바뀐 파일명
            move_uploaded_file($photo["tmp_name"], "../images/product/" . $crt_datetime . "_" .$photo["name"]);
            $photo_name = $photo["name"];
            $change_photo_name = $crt_datetime . "_" . $photo["name"];
        }

        $arr = [
            "ccode" => $ccode,
            "pcode" => $pcode,
            "country_ko" => $country_kr,
            "country_en" => $country_en,
            "price" => $price,
            "cnt" => $cnt,
            "name" => $name,
            "bio" => $bio,
            "photo" => $photo_name,
            "change_photo" => $change_photo_name,
            "create_by" => $session_id,
        ];

        $product -> addProcut($arr);
        $arr = ["result" => "success_add"];
        die(json_encode($arr));

    } else if ($mode == "update") {

        // 수정 시에는 상품 코드도 수정 할 수 있기 때문에 idx 기준으로 찾기
        $row = $product -> getProductFromIdx($idx);
        
        // 이미지 서버 폴더 저장 및 이미지 네이밍 변경
        $photo_name = "";
        $change_photo_name = "";
        $crt_datetime = date("Ymd" . time()); // 이미지명 중복 방지
        if ( !empty($photo) ) {

            // 이미지 확장자 검증
            list(, $etc) = explode(".", $photo["name"]);
            if ( !($etc == "png" || $etc == "PNG" || $etc == "jpg" || $etc == "JPG") ) {
                $arr = ["result" => "wrong_type"];
                die(json_encode($arr));
            }

            // 기존 파일 이미지 서버 폴더 삭제
            unlink("../images/product/" . $row["change_photo"]);
            
            // 파일 서버 업로드 기존 파일명, 바뀐 파일명
            move_uploaded_file($photo["tmp_name"], "../images/product/" . $crt_datetime . "_" .$photo["name"]);
            $photo_name = $photo["name"];
            $change_photo_name = $crt_datetime . "_" . $photo["name"];
            
        } else {
            if ($row != false) {
                $photo_name = $row["photo"];
                $change_photo_name = $row["change_photo"];
            }
        }

        $arr = [
            "idx" => $idx,
            "ccode" => $ccode,
            "pcode" => $pcode,
            "country_ko" => $country_kr,
            "country_en" => $country_en,
            "price" => $price,
            "cnt" => $cnt,
            "name" => $name,
            "bio" => $bio,
            "photo" => $photo_name,
            "change_photo" => $change_photo_name,
            "create_by" => $session_id,
        ];

        $product -> updateProduct($arr);
        $arr = ["result" => "success_update"];
        die(json_encode($arr));

    }
}