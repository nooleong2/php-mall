<?php
# DATABASE
include "../../database/database.php";

# PATH
include "../../define/define.php";

# CLASS
include "../class/category_manager.php";
$category = new CategoryManager($conn);

$mode = ( isset($_POST["mode"]) && $_POST["mode"] != "" ) ? $_POST["mode"] : "";
$name = ( isset($_POST["name"]) && $_POST["name"] != "" ) ? $_POST["name"] : "";
$bio = ( isset($_POST["bio"]) && $_POST["bio"] != "" ) ? $_POST["bio"] : "";
$photo = ( isset($_FILES["photo"]) && $_FILES["photo"] != "" ) ? $_FILES["photo"] : "";

// 빈 값 검증
if ($mode == "") {
    $arr = ["result" => "empty_mode"];
    die(json_encode($arr));
} else if ($name == "") {
    $arr = ["result" => "empty_name"];
    die(json_encode($arr));
}

// 모드 기능
if ($mode == "add") {

    // 카테고리 코드 생성
    $ccode = $category -> getCategoryLimitOneDesc();
    $num = substr($ccode["ccode"], 1);
    $num += 1;
    $ccode = "C" . $num;

    // 이미지 폴더 저장
    move_uploaded_file($photo["tmp_name"], "../images/category/" . $photo["name"]);
    
    $arr = [
        "ccode" => $ccode,
        "name" => $name,
        "bio" => $bio,
        "photo" => $photo["name"],
    ];

    $category -> addCategory($arr);

    $arr = ["result" => "success_add"];
    die(json_encode($arr));
}


