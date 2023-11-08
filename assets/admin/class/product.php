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

    // 카테고리 기준으로 해당 상품들 정보 가져오기
    public function getProductFromCategory($ccode) {
        $sql = "SELECT * FROM product WHERE ccode = :ccode;";
        $stmt = $this -> conn -> prepare($sql);
        $stmt -> bindParam(":ccode", $ccode);
        $stmt -> execute();
        $rows = $stmt -> fetchAll(PDO::FETCH_ASSOC);

        return $rows;
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

    // 상품 삭제
    public function deleteProduct($idx) {
        $sql = "DELETE FROM product WHERE idx = :idx";
        $stmt = $this -> conn -> prepare($sql);
        $stmt -> bindParam(":idx", $idx);
        $stmt -> execute();
    }

    // 찜 상품 추가
    public function pickAdd($arr) {
        $sql = "INSERT INTO pick (id, pcode, ccode) VALUES (:id, :pcode, :ccode)";
        $stmt = $this -> conn -> prepare($sql);
        $params = [
            ":id" => $arr["id"],
            ":pcode" => $arr["pcode"],
            ":ccode" => $arr["ccode"],
        ];
        $stmt -> execute($params);
    }

    // 찜 상품 삭제
    public function pickDelete($pcode) {
        $sql = "DELETE FROM pick WHERE pcode = :pcode";
        $stmt = $this -> conn -> prepare($sql);
        $stmt -> bindParam(":pcode", $pcode);
        $stmt -> execute();
    }

    // 찜 목록 가져오기
    public function getPickList($id) {
        $sql = "SELECT * FROM pick AS a JOIN product AS b ON a.pcode = b.pcode WHERE a.id = :id  ORDER BY a.idx DESC";
        $stmt = $this -> conn -> prepare($sql);
        $stmt -> bindParam(":id", $id);
        $stmt -> execute();
        $rows = $stmt -> fetchAll(PDO::FETCH_ASSOC);

        return $rows;
    }

    // 장바구니 추가
    public function addCartProduct($arr) {
        $sql = "INSERT INTO cart (id, pcode, cnt) VALUES (:id, :pcode, :cnt);";
        $stmt = $this -> conn -> prepare($sql);
        $params = [
            ":id" => $arr["id"],
            ":pcode" => $arr["pcode"],
            ":cnt" => $arr["cnt"],
        ];
        $stmt -> execute($params);
    }

    // 장바구니 상품 가져오기
    public function getCartProduct($id) {
        $sql = "SELECT c.idx, c.pcode, c.cnt, p.name,  p.change_photo, p.price FROM cart AS c JOIN product as p ON c.pcode = p.pcode WHERE c.id = :id ORDER BY c.idx DESC;";
        $stmt = $this -> conn -> prepare($sql);
        $stmt -> bindParam(":id", $id);
        $stmt -> execute();
        $rows = $stmt -> fetchAll(PDO::FETCH_ASSOC);

        return $rows;
    }

    // 장바구니 상품 삭제
    public function deleteCartProduct($idx) {
        $sql = "DELETE FROM cart WHERE idx = :idx";
        $stmt = $this -> conn -> prepare($sql);
        $stmt -> bindParam(":idx", $idx);
        $stmt -> execute();
    }

    // 주문 정보 가져오기
    public function getOrders() {
        $sql = "SELECT * FROM orders;";
        $stmt = $this -> conn -> prepare($sql);
        $stmt -> execute();
        $rows = $stmt -> fetchAll(PDO::FETCH_ASSOC);

        return $rows;
    }

    // 상품 주문
    public function order($arr) {
        $sql = "INSERT INTO orders (order_uid, m_id, m_name, m_phone, m_email, m_zipcode, m_addr, p_name, p_code, p_cnt, p_one_price, p_total_price)
                 VALUES (:order_uid, :m_id, :m_name, :m_phone, :m_email, :m_zipcode, :m_addr, :p_name, :p_code, :p_cnt, :p_one_price, :p_total_price);";
        $stmt = $this -> conn -> prepare($sql);
        $params = [
            ":order_uid" => $arr["order_uid"],
            ":m_id" => $arr["m_id"],
            ":m_name" => $arr["m_name"],
            ":m_phone" => $arr["m_phone"],
            ":m_email" => $arr["m_email"],
            ":m_zipcode" => $arr["m_zipcode"],
            ":m_addr" => $arr["m_addr"],
            ":p_name" => $arr["p_name"],
            ":p_code" => $arr["p_code"],
            ":p_cnt" => $arr["p_cnt"],
            ":p_one_price" => $arr["p_one_price"],
            ":p_total_price" => $arr["p_total_price"],
        ];
        $stmt -> execute($params);

        // 기존 상품 수 - 주문 수 = 현재 상품 수 (UPDATE 문)
        $row = $this -> getProductFromPcode($arr["p_code"]); // 해당 상품 정보 가져오기
        $sql = "UPDATE product SET cnt = :cnt WHERE pcode = :pcode";
        $stmt = $this -> conn -> prepare($sql);
        $result_cnt = $row["cnt"] - $arr["p_cnt"]; // 해당 기존 상품 수 - 주문 상품 수
        $stmt -> bindParam(":cnt", $result_cnt); 
        $stmt -> bindParam(":pcode", $arr["p_code"]);
        $stmt -> execute();
        
    }

    // 장바구니 상품 주문
    public function cartOrder($cartArr) {
        
        for ($i = 0; $i < count($cartArr); $i++) {
            // 상품 주문 데이터 베이스 추가
            $sql = "INSERT INTO orders (order_uid, m_id, m_name, m_phone, m_email, m_zipcode, m_addr, p_name, p_code, p_cnt, p_one_price, p_total_price)
                 VALUES (:order_uid, :m_id, :m_name, :m_phone, :m_email, :m_zipcode, :m_addr, :p_name, :p_code, :p_cnt, :p_one_price, :p_total_price);";
            $stmt = $this -> conn -> prepare($sql);
            $params = [
                ":order_uid" => $cartArr[$i]["order_uid"],
                ":m_id" => $cartArr[$i]["m_id"],
                ":m_name" => $cartArr[$i]["m_name"],
                ":m_phone" => $cartArr[$i]["m_phone"],
                ":m_email" => $cartArr[$i]["m_email"],
                ":m_zipcode" => $cartArr[$i]["m_zipcode"],
                ":m_addr" => $cartArr[$i]["m_addr"],
                ":p_name" => $cartArr[$i]["p_name"],
                ":p_code" => $cartArr[$i]["p_code"],
                ":p_cnt" => $cartArr[$i]["p_cnt"],
                ":p_one_price" => $cartArr[$i]["p_one_price"],
                ":p_total_price" => $cartArr[$i]["p_total_price"],
            ];
            $stmt -> execute($params);

            // 기존 상품 수 - 주문 수 = 현재 상품 수 (UPDATE 문)
            $row = $this -> getProductFromPcode($cartArr[$i]["p_code"]); // 해당 상품 정보 가져오기
            $sql = "UPDATE product SET cnt = :cnt WHERE pcode = :pcode";
            $stmt = $this -> conn -> prepare($sql);
            $result_cnt = $row["cnt"] - $cartArr[$i]["p_cnt"]; // 해당 기존 상품 수 - 주문 상품 수
            $stmt -> bindParam(":cnt", $result_cnt); 
            $stmt -> bindParam(":pcode", $cartArr[$i]["p_code"]);
            $stmt -> execute();
        }

        // 장바구니 상품 삭제
        $sql = "DELETE FROM cart WHERE id = :id";
        $stmt = $this -> conn -> prepare($sql);
        $stmt -> bindParam(":id", $cartArr[0]["m_id"]);
        $stmt -> execute();
    }

}