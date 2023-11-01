<?php
// GET QUERY
$pcode = ( isset($_GET["pcode"]) && $_GET["pcode"] != "" ) ? $_GET["pcode"] : "";
$ccode = ( isset($_GET["ccode"]) && $_GET["ccode"] != "" ) ? $_GET["ccode"] : "";

// SESSION
include "./inc/session.php";
if ($session_id == "" || $session_role != "A") {
    die("<script>alert('접근 권한이 없습니다.'); self.location.href = './login.php';</script>");
}

// DATABASE
include "../database/database.php";

// HEADER
$js_array = ["./js/product_update.js"];
$page_title = "상품 수정";
include "./inc/header.php";

// CLASS
include "./class/category_manager.php";
include "./class/product.php";
$cm = new CategoryManager($conn);
$product = new Product($conn);
$categorys = $cm -> getCategoryAll();
$row = $product -> getProductFromPcode($pcode);
?>

<div class="container-fluid">
        <?php
            # SIDE BAR
            include "./inc/sidebar.php";
        ?>
    
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mb-5">
            <div
                class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">상품 수정</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
                        <span data-feather="calendar" class="align-text-bottom"></span>
                        This week
                    </button>
                </div>
            </div>

            <div>
                <span>키테고리 선택</span>
                <!-- HIDDEN IDX -->
                <input type="hidden" value="<?= $row["idx"] ?>" id="idx">
                <select name="ccode" id="ccode" class="form-select w-25 mb-3">
                    <?php foreach ($categorys as $cateogry) { ?>
                        <option value="<?= $row["ccode"] ?>" <?= ($cateogry["ccode"] == $ccode) ? "selected" : ""; ?>><?= $cateogry["name"] ?></option>
                    <?php } ?>
                </select>
                <span>국가 코드(KR)</span>
                <select name="country_kr" id="country_kr" class="form-select w-25 mb-3">
                    <!-- HIDDEN COUNTRY_KO -->
                    <input type="hidden" value="<?= $row["country_ko"] ?>" id="hidden_country_ko">
                    <!-- 공공데이터 API로 제작 제작 -->
                </select>
                <span>국가 코드(EN)</span>
                <input type="text" id="country_en" name="country_en" class="form-control w-25" value="<?= $row["country_en"] ?>" readonly><br>
                <span>상품 코드</span>
                <input type="text" id="pcode" name="pcode" class="form-control w-25" value="<?= $row["pcode"] ?>"><br>
                <span>상품 가격(원)</span>
                <input type="number" id="price" name="price" class="form-control w-25" value="<?= $row["price"] ?>" autocomplete="off"><br>
                <span>상품 수</span>
                <input type="number" id="cnt" name="cnt" class="form-control w-25" value="<?= $row["cnt"] ?>" autocomplete="off"><br>
                <span>상품 이름</span>
                <input type="text" id="name" name="name" class="form-control w-50" value="<?= $row["name"] ?>" autocomplete="off"><br>
                <span>상품 소개</span>
                <input type="text" id="bio" name="bio" class="form-control w-50" value="<?= $row["bio"] ?>" autocomplete="off"><br>
                <span>상품 이미지</span>
                <input type="file" id="photo" name="photo" class="form-control w-50"><br>
                <img src="./images/product/<?= $row["change_photo"] ?>" alt="" id="preview" class="mb-3" style="width:200px; height:200px"><br>

                <button class="btn btn-primary" id="btn_update">수정</button>
            </div>

        </main>
    </div>

    </body>
</html>