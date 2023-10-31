<?php

class Member {

    private $conn;

    public function __construct($conn) {
        $this -> conn = $conn;
    }

    // 관리자 로그인
    public function login($arr) {
        $sql = "SELECT * FROM MEMBER WHERE id = :id";
        $stmt = $this -> conn -> prepare($sql);
        $stmt -> bindParam(":id", $arr["id"]);
        $stmt -> execute();

        // 1-1. 아이디와 동일한게 있으면 가져 옴
        if ($stmt -> rowCount()) {
            $row = $stmt -> fetch(PDO::FETCH_ASSOC);

            // 2. 비밀번호 해쉬값 비교
            if (password_verify($arr["password"], $row["password"])) {
                return true;
            } else {
                return false;
            }
        } else {
            // 1-2. 아이디가 존재하지 않는다.
            return false;
        }
    }

    // 관리자 로그아웃
    public function logout() {
        session_start();
        session_destroy();
        
        die("<script>alert('관리자 로그아웃 하셨습니다.'); self.location.href = '../index.php';</script>");
    }
}