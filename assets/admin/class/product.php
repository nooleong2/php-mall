<?php

class Product {
    
    private $conn;

    public function __construct($conn) {
        $this -> conn = $conn;
    }

    // 상품 전체 가져오기
    public function getProductAll() {
        $sql = "SELECT * FROM product;";
        $stmt = $this -> conn -> prepare($sql);
        $stmt -> execute();
        $rows = $stmt -> fetchAll(PDO::FETCH_ASSOC);

        return $rows;
    }

    // 상품 코드 기준으로 해당 상품 정보 가져오기
    public function getProductFromPcode($pcode) {
        $sql = "SELECT * FROM product WHERE pcode = :pcode;";
        $stmt = $this -> conn -> prepare($sql);
        $stmt -> bindParam(":pcode", $pcode);
        $stmt -> execute();
        $row = $stmt -> fetch(PDO::FETCH_ASSOC);

        return $row;
    }

    // idx 기준으로 해당 상품 정보 가져오기
    public function getProductFromIdx($idx) {
        $sql = "SELECT * FROM product WHERE idx = :idx;";
        $stmt = $this -> conn -> prepare($sql);
        $stmt -> bindParam(":idx", $idx);
        $stmt -> execute();
        $row = $stmt -> fetch(PDO::FETCH_ASSOC);

        return $row;
    }
    
    // 상품 등록
    public function addProcut($arr) {
        $sql = "INSERT INTO product (ccode, pcode, name, bio, photo, change_photo, price, cnt, country_ko, country_en, create_by) 
                VALUES (:ccode, :pcode, :name, :bio, :photo, :change_photo, :price, :cnt, :country_ko, :country_en, :create_by);";

        $stmt = $this -> conn -> prepare($sql);
        $arr = [
            ":ccode" => $arr["ccode"],
            ":pcode" => $arr["pcode"],
            ":name" => $arr["name"],
            ":bio" => $arr["bio"],
            ":photo" => $arr["photo"],
            ":change_photo" => $arr["change_photo"],
            ":price" => ((int) $arr["price"]),
            ":cnt" => ((int) $arr["cnt"]),
            ":country_ko" => $arr["country_ko"],
            ":country_en" => $arr["country_en"],
            ":create_by" => $arr["create_by"],
        ];

        $stmt -> execute($arr);
    }

    // 상품 수정
    public function updateProduct($arr) {

        $sql = "UPDATE product SET ccode = :ccode, pcode = :pcode, name = :name, bio = :bio, photo = :photo, change_photo = :change_photo, price = :price, cnt = :cnt, country_ko = :country_ko, country_en = :country_en, create_by = :create_by
        WHERE idx = :idx";

        $stmt = $this -> conn -> prepare($sql);
        $arr = [
            ":ccode" => $arr["ccode"],
            ":pcode" => $arr["pcode"],
            ":name" => $arr["name"],
            ":bio" => $arr["bio"],
            ":photo" => $arr["photo"],
            ":change_photo" => $arr["change_photo"],
            ":price" => ((int) $arr["price"]),
            ":cnt" => ((int) $arr["cnt"]),
            ":country_ko" => $arr["country_ko"],
            ":country_en" => $arr["country_en"],
            ":create_by" => $arr["create_by"],
            ":idx" => $arr["idx"],
        ];

        $stmt -> execute($arr);

    }
}