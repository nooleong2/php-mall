<?php
// GET INFO
$ccode = ( isset($_GET["ccode"]) && $_GET["ccode"] != "" ) ? $_GET["ccode"] : "";
$pcode = ( isset($_GET["pcode"]) && $_GET["pcode"] != "" ) ? $_GET["pcode"] : "";
if ($pcode == "") {
    die("<script>alert('상품 코드가 존재하지 않습니다.'); self.location.href = './product.php?ccode=" . $ccode . "';</script>");
}

// SESSION
include "./assets/admin/inc/session.php";

// DATABASE
include "./assets/database/database.php";

// CLASS
include "./assets/admin/class/category_manager.php";
include "./assets/admin/class/product.php";
$cm = new CategoryManager($conn);
$categorys = $cm -> getCategoryAll();

$pd = new Product($conn);
$product = $pd -> getProductFromPcode($pcode);

// HEADER
$js_array = ["./js/detail.js"];
include "./inc/inc_header.php";
?>

<div class="container">
    <main style="margin-top:100px; height:100vh;">

        <h2 class="mb-5 text-center">구매하기</h2>
        
        <div class="container">
            <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                <div class="col-auto">
                    <img class="p-3" width="200" height="250" src="./assets/admin/images/product/<?= $product["change_photo"] ?>" alt="">
                </div>
                <div class="col p-4 d-flex flex-column position-static border-start">
                    <div>
                        <strong class="d-inline-block mb-2 text-primary">디테일 정보</strong>
                        <button class="btn btn-sm btn-success" id="btn_cart">장바구니 추가</button>
                    </div>
                    <input type="hidden" id="id" value="<?= $session_id ?>">
                    <input type="hidden" id="pcode" value="<?= $product["pcode"] ?>">
                    <h3 class="mb-3">상품명: <?= $product["name"] ?></h3>
                    <div class="mb-3 text-danger">가격: <span id="price"><?= $product["price"] ?></span>원</div>
                    <div>
                        개수: <input id="cnt" class="mb-3" type="number" min="1" max="999" value="1" maxlength="3">
                    </div>
                    <p class="card-text mb-3">내용: <?= $product["bio"] ?></p>
                    <div class="d-flex gap-2">
                        <button class="btn btn-outline-primary w-50">구매하기</button>
                        <button class="btn btn-outline-danger w-50">뒤로가기</button>
                    </div>
                </div>
            </div>
        </div>

        <footer class="container my-5">
            <p class="float-end"><a href="#">Back to top</a></p>
            <p>&copy; 2017–2022 Company, Inc. &middot; <a href="#">Privacy</a> &middot; <a href="#">Terms</a></p>
    </footer>
    </main>
</div>

</body>
</html>

