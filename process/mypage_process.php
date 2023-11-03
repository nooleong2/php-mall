<?php
// DATABASE
include "../assets/database/database.php";

// CLASS
include "../assets/admin/class/member.php";

$id = ( isset($_POST["id"]) && $_POST["id"] != "" ) ? $_POST["id"] : "";
$password = ( isset($_POST["password"]) && $_POST["password"] != "" ) ? $_POST["password"] : "";
$name = ( isset($_POST["name"]) && $_POST["name"] != "" ) ? $_POST["name"] : "";
$zipcode = ( isset($_POST["zipcode"]) && $_POST["zipcode"] != "" ) ? $_POST["zipcode"] : "";
$addr1 = ( isset($_POST["addr1"]) && $_POST["addr1"] != "" ) ? $_POST["addr1"] : "";
$addr2 = ( isset($_POST["addr2"]) && $_POST["addr2"] != "" ) ? $_POST["addr2"] : "";
$photo = ( isset($_FILES["photo"]) && $_FILES["photo"] != "" ) ? $_FILES["photo"] : "";

// 클래스 생성
$member = new Member($conn);
$mem_row = $member -> getMemberInfo($id);

if ($id == "") {
    $arr = ["result" => "empty_id"];
    die(json_encode($arr));
}

$photo_name = "";
$change_photo_name = "";
if ( !empty($photo) ) {

    list(, $etc) = explode(".", $photo["name"]);
    if (!($etc == "png" || $etc == "PNG" || $etc == "JPG" || $etc == "jpg")) {
        $arr = ["result" => "wrong_type"];
    die(json_encode($arr));
    }

    unlink("../images/" . $mem_row["change_photo"]);

    $photo_name = $photo["name"];
    $change_photo_name = $id . "_" . $photo["name"];
    move_uploaded_file($photo["tmp_name"], "../images/" . $change_photo_name);
    
} else {
    $photo_name = $mem_row["photo"];
    $change_photo_name = $mem_row["change_photo"];
}

$enc_password = "";
if ( !empty($password)) {
    $enc_password = password_hash($password, PASSWORD_BCRYPT);
} else {
    $enc_password = $mem_row["password"];
}

$arr = [
    "id" => $id,
    "password" => $enc_password,
    "name" => $name,
    "zipcode" => $zipcode,
    "addr1" => $addr1,
    "addr2" => $addr2,
    "photo" => $photo_name,
    "change_photo" => $change_photo_name
];

$member -> updateMember($arr);
$arr = ["result" => "success"];
die(json_encode($arr));