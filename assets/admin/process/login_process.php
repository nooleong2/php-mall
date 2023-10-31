<?php
// DATABASE
include "../../database/database.php";

// CLASS
include "../class/member.php";
$member = new Member($conn);

$id = ( isset($_POST["id"]) && $_POST["id"] != "" ) ? $_POST["id"] : "";
$password = ( isset($_POST["password"]) && $_POST["password"] != "" ) ? $_POST["password"] : "";

// 아이디 빈 값 검증
if ($id == "") {
    $arr = ["result" => "empty_id"];
    die(json_encode($arr));
}

// 비밀번호 빈 값 검증
if ($password == "") {
    $arr = ["result" => "empty_password"];
    die(json_encode($arr));
}

// 로그인 기능
$arr = [
    "id" => $id,
    "password" => $password,
];

$result = $member -> login($arr);

if ($result) {
    session_start();
    $_SESSION["session_id"] = $id;
    $_SESSION["session_role"] = "A";

    $arr = ["result" => "success_login"];
    die(json_encode($arr));

} else {
    $arr = ["result" => "fail_login"];
    die(json_encode($arr));
}




