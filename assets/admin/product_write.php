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

// CLASS
include "./class/category_manager.php";
$cm = new CategoryManager($conn);
$categorys = $cm -> getCategoryAll();
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
                <select name="ccode" id="ccode" class="form-select w-25 mb-3">
                    <?php foreach ($categorys as $cateogry) { ?>
                        <option value="<?= $cateogry["ccode"] ?>"><?= $cateogry["name"] ?></option>
                    <?php } ?>
                </select>
                <span>국가 코드(KR)</span>
                <select name="country_kr" id="country_kr" class="form-select w-25 mb-3">
                    <!-- 공공 데이터로 제작 -->
                </select>
                <span>국가 코드(EN)</span>
                <input type="text" id="country_en" name="country_en" class="form-control w-25" value="KOR"><br>
                <span>상품 코드</span>
                <input type="text" id="pcode" name="pcode" class="form-control w-25" maxlength="10"><br>
                <span>상품 가격(원)</span>
                <input type="number" id="price" name="price" class="form-control w-25" autocomplete="off" min="1" max="999"><br>
                <span>상품 수</span>
                <input type="number" id="cnt" name="cnt" class="form-control w-25" autocomplete="off" min="1" max="999"><br>
                <span>상품 이름</span>
                <input type="text" id="name" name="name" class="form-control w-50" autocomplete="off"><br>
                <span>상품 소개</span>
                <input type="text" id="bio" name="bio" class="form-control w-50" autocomplete="off"><br>
                <span>상품 이미지</span>
                <input type="file" id="photo" name="photo" class="form-control w-50"><br>
                <img src="" alt="" id="preview" class="mb-3" style="width:200px; height:200px"><br>

                <button class="btn btn-primary" id="btn_submit">등록</button>
            </div>

        </main>
    </div>

    </body>
</html>