<?php

class CategoryManager {
    
    private $conn;

    public function __construct($conn) {
        $this -> conn = $conn;
    }

    // 전체 카테고리 목록 가져오기
    public function getCategoryAll() {
        $sql = "SELECT * FROM category_manager;";
        $stmt = $this -> conn -> prepare($sql);
        $stmt -> execute();
        $rows = $stmt -> fetchAll(PDO::FETCH_ASSOC);

        return $rows;
    }

    // 카테고리 추가
    public function addCategory($arr) {
        
        $sql = "INSERT INTO category_manager (ccode, name, bio, photo, create_by) VALUES (:ccode, :name, :bio, :photo, :create_by);";
        $stmt = $this -> conn -> prepare($sql);
        $arr = [
            ":ccode" => $arr["ccode"],
            ":name" => $arr["name"],
            ":bio" => $arr["bio"],
            ":photo" => $arr["photo"],
            ":create_by" => "system",
        ];
        $stmt -> execute($arr);
    }

    // 제일 큰 카테고리 코드 1개 가져오기
    public function getCategoryLimitOneDesc() {
        $sql = "SELECT ccode FROM category_manager ORDER BY idx DESC LIMIT 1;";
        $stmt = $this -> conn -> prepare($sql);
        $stmt -> execute();
        $row = $stmt -> fetch(PDO::FETCH_ASSOC);

        return $row;
    }
}