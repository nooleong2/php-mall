<?php

class CategoryManager {
    
    private $conn;

    public function __construct($conn) {
        $this -> conn = $conn;
    }

    // 카테고리 idx 기준으로 정보 가져오기
    public function getCategoryFromIdx($idx) {
        $sql = "SELECT * FROM category_manager WHERE idx = :idx";
        $stmt = $this -> conn -> prepare($sql);
        $stmt -> bindParam(":idx", $idx);
        $stmt -> execute();
        $row = $stmt -> fetch(PDO::FETCH_ASSOC);

        return $row;
    }

    // 전체 카테고리 목록 가져오기
    public function getCategoryAll() {
        $sql = "SELECT * FROM category_manager;";
        $stmt = $this -> conn -> prepare($sql);
        $stmt -> execute();
        $rows = $stmt -> fetchAll(PDO::FETCH_ASSOC);

        return $rows;
    }

    // 제일 큰 카테고리 코드 1개 가져오기
    public function getCategoryLimitOneDesc() {
        $sql = "SELECT ccode FROM category_manager ORDER BY idx DESC LIMIT 1;";
        $stmt = $this -> conn -> prepare($sql);
        $stmt -> execute();
        $row = $stmt -> fetch(PDO::FETCH_ASSOC);

        return $row;
    }

    // 카테고리 추가
    public function addCategory($arr) {
        $sql = "INSERT INTO category_manager (ccode, name, bio, photo, change_photo, create_by) VALUES (:ccode, :name, :bio, :photo, :change_photo, :create_by);";
        $stmt = $this -> conn -> prepare($sql);
        $arr = [
            ":ccode" => $arr["ccode"],
            ":name" => $arr["name"],
            ":bio" => $arr["bio"],
            ":change_photo" => $arr["change_photo"],
            ":photo" => $arr["photo"],
            ":create_by" => $arr["create_by"],
        ];
        $stmt -> execute($arr);
    }

    // 카테고리 수정
    public function updateCategory($arr) {
        $sql = "UPDATE category_manager SET name = :name, bio = :bio, photo = :photo, change_photo = :change_photo, update_by = :update_by, update_at = NOW() WHERE idx = :idx";
        $stmt = $this -> conn -> prepare($sql);
        $arr = [
            ":name" => $arr["name"],
            ":bio" => $arr["bio"],
            ":photo" => $arr["photo"],
            ":change_photo" => $arr["change_photo"],
            "update_by" => $arr["update_by"],
            "idx" => $arr["idx"],
        ];
        $stmt -> execute($arr);
    }

    // 카테고리 삭제
    public function deleteCategory($idx) {
        $sql = "DELETE FROM category_manager WHERE idx = :idx";
        $stmt = $this -> conn -> prepare($sql);
        $stmt -> bindParam(":idx", $idx);
        $stmt -> execute();
    }
    
}