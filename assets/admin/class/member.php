<?php

class Member {

    private $conn;

    public function __construct($conn) {
        $this -> conn = $conn;
    }

    // 회원 수정
    public function updateMember($arr) {
        $sql = "UPDATE member SET password = :password, name = :name, zipcode = :zipcode, addr1 = :addr1, addr2 = :addr2, photo = :photo, change_photo = :change_photo, update_by = :update_by, update_at = :update_at WHERE id = :id ";

        $stmt = $this -> conn -> prepare($sql);
        $params = [
            ":password" => $arr["password"],
            ":name" => $arr["name"],
            ":zipcode" => $arr["zipcode"],
            ":addr1" => $arr["addr1"],
            ":addr2" => $arr["addr2"],
            ":photo" => $arr["photo"],
            ":change_photo" => $arr["change_photo"],
            ":update_by" => $arr["id"],
            ":update_at" => date("Y-m-d H:i:s"),
            ":id" => $arr["id"],
        ];
        $stmt -> execute($params);
    }

    // 아이디 이메일 검증
    public function idOrEmailCheck($param, $valid) {
        $where = "";
        switch ($valid) {
            case "id":
                $where = "WHERE id = :id";
                break;
            case "email":
                $where = "WHERE email = :email";
                break;
        }
        $sql = "SELECT COUNT(*) AS cnt FROM member " . $where;
        $stmt = $this -> conn -> prepare($sql);
        
        switch ($valid) {
            case "id":
                $stmt -> bindParam(":id", $param);
                break;
            case "email":
                $stmt -> bindParam(":email", $param);
                break;
        }

        $stmt -> execute();
        $row = $stmt -> fetch(PDO::FETCH_ASSOC);

        return $row;
    }

    // 회원 가입
    public function register($arr) {
        $sql = "INSERT INTO member (id, password, email, name, zipcode, addr1, addr2, photo, change_photo)
                VALUES (:id, :password, :email, :name, :zipcode, :addr1, :addr2, :photo, :change_photo)";

        $stmt = $this -> conn -> prepare($sql);
        $params = [
            ":id" => $arr["id"],
            ":password" => $arr["password"],
            ":email" => $arr["email"],
            ":name" => $arr["name"],
            ":zipcode" => $arr["zipcode"],
            ":addr1" => $arr["addr1"],
            ":addr2" => $arr["addr2"],
            ":photo" => $arr["photo"],
            ":change_photo" => $arr["change_photo"],
        ];
        $stmt -> execute($params);
    }

    // 로그인
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

    // 로그아웃
    public function logout($path) {
        session_start(); //세션시작
        session_unset(); // 현재 연결된 세션에 등록되어 있는 모든 변수의 값을 삭제한다
        session_destroy(); //현재의 세션을 종료한다

        if (!empty($path)) {
            die("<script>alert('로그아웃 하셨습니다.'); self.location.href = '../../../index.php';</script>");
        } else {
            die("<script>alert('로그아웃 하셨습니다.'); self.location.href = '../index.php';</script>");
        }   
    }

    // 회원정보 가져오기
    public function getMemberInfo($id) {
        $sql = "SELECT * FROM member WHERE id = :id";
        $stmt = $this -> conn -> prepare($sql);
        $stmt -> bindParam(":id", $id);
        $stmt -> execute();
        $row = $stmt -> fetch(PDO::FETCH_ASSOC);

        return $row;
    }
}