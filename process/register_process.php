<?php
// DATABASE
include "../assets/database/database.php";

// CLASS
include "../assets/admin/class/member.php";
$member = new Member($conn);

$valid = ( isset($_POST["valid"]) && $_POST["valid"] != "" ) ? $_POST["valid"] : "";

if ($valid != "") {
    // 검증할 대상이 뭔지에 따라 $param의 값 변경
    if ($valid == "id") {
        $param = ( isset($_POST["id"]) && $_POST["id"] != "" ) ? $_POST["id"] : "";
    } else if ($valid == "email") {
        $param = ( isset($_POST["email"]) && $_POST["email"] != "" ) ? $_POST["email"] : "";
    }
    
    $row = $member -> idOrEmailCheck($param, $valid);
    
    // 데이터베이스에 검증 대상이 존재한다면 이미 사용 중인 아이디/이메일
    if ($row["cnt"] != 0) {
        $arr = ["result" => "already_param"];
        die(json_encode($arr));
    }
    
    $arr = ["result" => "success"];
    die(json_encode($arr));

} else {
    $id = ( isset($_POST["id"]) && $_POST["id"] != "" ) ? $_POST["id"] : "";
    $password = ( isset($_POST["password"]) && $_POST["password"] != "" ) ? $_POST["password"] : "";
    $email = ( isset($_POST["email"]) && $_POST["email"] != "" ) ? $_POST["email"] : "";
    $name = ( isset($_POST["name"]) && $_POST["name"] != "" ) ? $_POST["name"] : "";
    $zipcode = ( isset($_POST["zipcode"]) && $_POST["zipcode"] != "" ) ? $_POST["zipcode"] : "";
    $addr1 = ( isset($_POST["addr1"]) && $_POST["addr1"] != "" ) ? $_POST["addr1"] : "";
    $addr2 = ( isset($_POST["addr2"]) && $_POST["addr2"] != "" ) ? $_POST["addr2"] : "";
    $photo = ( isset($_FILES["photo"]) && $_FILES["photo"] != "" ) ? $_FILES["photo"] : "";

    if ($id == "") {
        $arr = ["result" => "empty_id"];
        die(json_encode($arr));
    } else if ($password == "") {
        $arr = ["result" => "empty_password"];
        die(json_encode($arr));
    } else if ($email == "") {
        $arr = ["result" => "empty_email"];
        die(json_encode($arr));
    } else if ($name == "") {
        $arr = ["result" => "empty_name"];
        die(json_encode($arr));
    }

    // 이미지 서버 저장
    $photo_name = "";
    $change_photo = "";
    if (!empty($photo)) {

        // 이미지 확장자 검증
        list(, $etc)  = explode(".", $photo["name"]);
        if (!($etc == "png" || $etc == "PNG" || $etc == "jpg" || $etc == "JPG")) {
            $arr = ["result" => "wrong_type"];
            die(json_encode($arr));
        }    

        // 이미지 서버 폴더 저장 및 중복 방지 이름 변경
        $photo_name = $photo["name"];
        $change_photo = $id . "_" . $photo["name"];
        move_uploaded_file($photo["tmp_name"], "../images/" . $change_photo);
    }

    // 비밀번호 해쉬 변경
    $enc_password = password_hash($password, PASSWORD_BCRYPT);

    $arr = [
        "id" => $id,
        "password" => $enc_password,
        "email" => $email,
        "name" => $name,
        "zipcode" => $zipcode,
        "addr1" => $addr1,
        "addr2" => $addr2,
        "photo" => $photo_name,
        "change_photo" => $change_photo,
    ];

    $member -> register($arr);
    $arr = ["result" => "success"];
    die(json_encode($arr));
}




