<?php
// SESSION
include "./assets/admin/inc/session.php";
if ($session_id == "") {
    die("<script>alert('로그인 후 접근 가능한 페이지입니다.'); self.location.href = './login.php';</script>");
}

// DATABASE
include "./assets/database/database.php";

// CLASS
include "./assets/admin/class/category_manager.php";
include "./assets/admin/class/product.php";
$cm = new CategoryManager($conn);
$categorys = $cm -> getCategoryAll();

$pd = new Product($conn);
$products = $pd -> getCartProduct($session_id);
// HEADER
$js_array = ["./js/cart.js"];
include "./inc/inc_header.php";
?>

    <main style="margin-top:100px; height:100vh;">

        <h2 class="mb-5 text-center">장바구니</h2>
        
        <div class="container">

        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">번호</th>
                    <th scope="col">이미지</th>
                    <th scope="col">상품명</th>
                    <th scope="col">가격</th>
                    <th scope="col">수량</th>
                    <th scope="col">비고</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product) { ?>
                    <input type="hidden" id="og_price" value="<?= $product["price"] ?>">
                    <input type="hidden" id="og_cnt" value="<?= $product["cnt"] ?>">
                <tr>
                    <td id="idx"><?= $product["idx"] ?></td>
                    <td><img src="./assets/admin/images/product/<?= $product["change_photo"] ?>" alt="" style="width:40px; height:40px;"></td>
                    <td><?= $product["name"] ?></td>
                    <td><span id="price"><?= $product["price"] ?></span>원</td>
                    <td><span id="cnt"><?= $product["cnt"] ?></span>개</td>
                    <td>
                        <button class="btn btn-sm btn-danger" data-idx="<?= $product["idx"] ?>" id="btn_delete">삭제</button>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <div class="text-end">
            <h3>총 금액: <span id="total_price">1000</span>원</h3>
            <button class="btn btn btn-outline-primary">구매하기</button>
        </div>
            
        </div>

        <footer class="container my-5">
            <p class="float-end"><a href="#">Back to top</a></p>
            <p>&copy; 2017–2022 Company, Inc. &middot; <a href="#">Privacy</a> &middot; <a href="#">Terms</a></p>
    </footer>
    </main>

</body>
</html>