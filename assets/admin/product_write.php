<?php
// SESSION
include "./inc/session.php";
if ($session_id == "" || $session_role != "A") {
    die("<script>alert('접근 권한이 없습니다.'); self.location.href = './login.php';</script>");
}

// DATABASE
include "../database/database.php";

// HEADER
$js_array = ["./js/product_write.js"];
$page_title = "상품 추가";
include "./inc/header.php";
?>

<div class="container-fluid">
        <?php
            # SIDE BAR
            include "./inc/sidebar.php";
        ?>
    
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mb-5">
            <div
                class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">상품 추가</h1>
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
                <select name="category_name" id="category_name" class="form-select w-25 mb-3">
                    <!-- JAVASCRIPT 제작 -->
                </select>
                <span>상품 코드(KR)</span>
                <select name="country_kr" id="country_kr" class="form-select w-25 mb-3">
                    <option value="">대한민국</option>
                </select>
                <span>상품 코드(EN)</span>
                <input type="text" id="country_en" name="country_en" class="form-control w-25" value="KOR"><br>
                <span>상품 가격(원)</span>
                <input type="text" id="name" name="name" class="form-control w-25" autocomplete="off"><br>
                <span>상품 수</span>
                <input type="text" id="name" name="name" class="form-control w-25" autocomplete="off"><br>
                <span>상품 이름</span>
                <input type="text" id="name" name="name" class="form-control w-50" autocomplete="off"><br>
                <span>상품 소개</span>
                <input type="text" id="name" name="name" class="form-control w-50" autocomplete="off"><br>
            </div>

        </main>
    </div>