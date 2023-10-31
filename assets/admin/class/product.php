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

    // 상품코드 기준으로 해당 상품 정보 가져오기
    public function getProductFromPcode($pcode) {
        $sql = "SELECT * FROM product WHERE pcode = :pcode;";
        $stmt = $this -> conn -> prepare($sql);
        $stmt -> bindParam(":pcode", $pcode);
        $stmt -> execute();
        $row = $stmt -> fetch(PDO::FETCH_ASSOC);

        return $row;
    }
}