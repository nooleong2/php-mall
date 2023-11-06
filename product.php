<?php
// SESSION
include "./assets/admin/inc/session.php";

// DATABASE
include "./assets/database/database.php";

// CLASS
include "./assets/admin/class/category_manager.php";
include "./assets/admin/class/product.php";
$cm = new CategoryManager($conn);
$categorys = $cm -> getCategoryAll();

$ccode = ( isset($_GET["ccode"]) && $_GET["ccode"] != "" ) ? $_GET["ccode"] : "";

$product = new Product($conn);
$products = $product -> getProductFromCategory($ccode);

// HEADER
$js_array = ["./js/product.js"];
include "./inc/inc_header.php";
?>

<div class="container">
    <main style="margin-top:100px; height:100vh;">

        <h2 class="mb-5 text-center">상품 목록</h2>
        <div class="row d-flex gap-2 justify-content-center">
            <!-- HIDDEN SESSION ID -->
            <input type="hidden" id="session_id" value="<?= $session_id ?>">
            <?php if (!empty($products)) {?>
                <?php foreach ($products as $product) { ?>
                <div class="card" style="width: 18rem;">
                    <img src="./assets/admin/images/product/<?= $product["change_photo"] ?>" class="card-img-top p-3">
                    <div class="card-body">
                        <h5 class="card-title"><?= $product["name"] ?></h5>
                        <p class="card-text"><?= $product["bio"] ?></p>
                        <span class="card-text text-danger">가격: <span id="price"><?= $product["price"] ?></span>원</span><br>
                        <span class="card-text text-warning">수량: <span id="cnt"><?= $product["cnt"] ?></span>개</span><br>
                        <div class="mt-2 d-flex justify-content-between">
                            <button class="btn btn-sm btn-danger" id="btn_pick" data-pcode="<?= $product["pcode"] ?>">찜 추가</button>
                            <a href="./detail.php?ccode=<?= $product["ccode"] ?>&pcode=<?= $product["pcode"] ?>" class="btn btn-sm btn-success">구매하기</a>
                        </div>
                    </div>
                </div>
                <?php } ?>
            <?php } else { ?>
                <h2 class="text-center text-secondary"><?= "상품 준비중 입니다." ?></h2>
            <?php } ?>
        </div>
        <footer class="container my-5">
            <p class="float-end"><a href="#">Back to top</a></p>
            <p>&copy; 2017–2022 Company, Inc. &middot; <a href="#">Privacy</a> &middot; <a href="#">Terms</a></p>
    </footer>
    </main>
</div>

</body>
</html>

