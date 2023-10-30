<?php

class Member {

    private $conn;

    public function __construct($conn) {
        $this -> conn = $conn;
    }

    // 관리자 로그인
    public function signin($arr) {
        $sql = "SELECT * FROM MEMBER WHERE id = :id AND password = :password;";
        $stmt = $this -> conn -> prepare($sql);
        $arr = [
            ":id" => $arr["id"],
            ":password" => $arr["password"],
        ];
        $stmt -> execute($arr);
        $row = $stmt -> fetch(PDO::FETCH_ASSOC);

        return $row;
    }

    // 관리자 로그아웃
    public function logout() {
        session_start();
        session_destroy();
        
        die("<script>alert('관리자 로그아웃 하셨습니다.'); self.location.href = '../index.php';</script>");
    }
}