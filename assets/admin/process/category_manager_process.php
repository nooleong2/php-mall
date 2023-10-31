<?php
# DATABASE
include "../../database/database.php";

# SESSION
include "../inc/session.php";

# CLASS
include "../class/category_manager.php";
$category = new CategoryManager($conn);

$mode = ( isset($_POST["mode"]) && $_POST["mode"] != "" ) ? $_POST["mode"] : "";
$idx = ( isset($_POST["idx"]) && $_POST["idx"] != "" && is_numeric($_POST["idx"]) ) ? $_POST["idx"] : "";
$name = ( isset($_POST["name"]) && $_POST["name"] != "" ) ? $_POST["name"] : "";
$bio = ( isset($_POST["bio"]) && $_POST["bio"] != "" ) ? $_POST["bio"] : "";
$photo = ( isset($_FILES["photo"]) && $_FILES["photo"] != "" ) ? $_FILES["photo"] : "";

// 모드 빈 값 검증
if ($mode == "") {
    $arr = ["result" => "empty_mode"];
    die(json_encode($arr));
}

// 모드 기능
if ($mode == "add") {

    // 카테고리 이름 빈 값 검증
    if ($name == "") {
        $arr = ["result" => "empty_name"];
        die(json_encode($arr));
    }

    // 이미지 확장자 검증
    list(, $etc) = explode(".", $photo["name"]);
    if ( !($etc == "png" || $etc == "PNG" || $etc == "jpg" || $etc == "JPG") ) {
        $arr = ["result" => "wrong_type"];
        die(json_encode($arr));
    }

    // 카테고리 코드 생성
    $ccode = $category -> getCategoryLimitOneDesc();
    if ($ccode == false) {
        $ccode = "C1";
    } else {
        $num = substr($ccode["ccode"], 1);
        $num += 1;
        $ccode = "C" . $num;
    }

    // 이미지 폴더 저장
    $photo_name = "";
    $change_photo = "";
    $current_datetime = date("Ymd" . time());

    if ($photo) {
        move_uploaded_file($photo["tmp_name"], "../images/category/" . $current_datetime . "_" . $photo["name"]);
        $photo_name = $photo["name"];
        $change_photo = $current_datetime . "_" . $photo["name"];
    }
    
    $arr = [
        "ccode" => $ccode,
        "name" => $name,
        "bio" => $bio,
        "photo" => $photo_name,
        "change_photo" => $change_photo,
        "create_by" => $session_id,
    ];

    $category -> addCategory($arr);

    $arr = ["result" => "success_add"];
    die(json_encode($arr));

} else if ($mode == "get_info") {
    
    $row = $category -> getCategoryFromIdx($idx);
    $list = [
        "idx" => $row["idx"],
        "name" => $row["name"],
        "bio" => $row["bio"],
    ];

    $arr = [
        "result" => "success_get_info",
        "list" => $list,
    ];
    die(json_encode($arr));

} else if ($mode == "update") {

    // 카테고리 이름 빈 값 검증
    if ($name == "") {
        $arr = ["result" => "empty_name"];
        die(json_encode($arr));
    }

    // 게시물 번호 빈 값 검증
    if ($idx == "") {
        $arr = ["result" => "empty_idx"];
        die(json_encode($arr));
    }

    // 이미지 비었으면 기존 이미지, 이미지가 있다면 바뀐 이미지
    $row = $category -> getCategoryFromIdx($idx);
    $photo_name = "";
    $change_photo = "";
    $current_datetime = date("Ymd" . time());

    if ($photo == "") {
        $photo_name = $row["photo"];
        $change_photo = $row["change_photo"];
    } else {

        // 이미지 확장자 검증
        list(, $etc) = explode(".", $photo["name"]);
        if ( !($etc == "png" || $etc == "PNG" || $etc == "jpg" || $etc == "JPG") ) {
            $arr = ["result" => "wrong_type"];
            die(json_encode($arr));
        }

        if ($row["change_photo"] != "") {
            unlink("../images/category/" . $row["change_photo"]);
        }
        move_uploaded_file($photo["tmp_name"], "../images/category/" . $current_datetime . "_" . $photo["name"]);
        $photo_name = $photo["name"];
        $change_photo = $current_datetime . "_" . $photo_name;
    }

    $arr = [
        "idx" => $idx,
        "name" => $name,
        "bio" => $bio,
        "photo" => $photo_name,
        "change_photo" => $change_photo,
        "update_by" => $session_id,
    ];

    $category -> updateCategory($arr);

    $arr = ["result" => "success_update"];
    die(json_encode($arr));

} else if ($mode == "delete") {

    // 게시물 번호 빈 값 검증
    if ($idx == "") {
        $arr = ["result" => "empty_idx"];
        die(json_encode($arr));
    }
    
    // 카테고리 이미지 삭제
    $row = $category -> getCategoryFromIdx($idx);
    if ($row["photo"] != "") {
        unlink("../images/category/" . $row["change_photo"]);
    }

    $arr = ["idx" => $idx];
    $category -> deleteCategory($idx);
    
    $arr = ["result" => "success_delete"];
    die(json_encode($arr));
}


