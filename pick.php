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

$product = new Product($conn);
$picks = $product -> getPickList($session_id);

// HEADER
$js_array = ["./js/pick.js"];
include "./inc/inc_header.php";
?>

    <div class="container">
        <main style="margin-top:100px; height:100vh;">
        <h2 class="mb-5 text-center">찜 목록</h2>
        <table class="table table-striped">
            <colgroup>
                <col width="10%">
                <col width="10%">
                <col width="60%">
                <col width="10%">
                <col width="10%">
            </colgroup>
            <thead>
                <tr>
                    <th>이미지</th>
                    <th>이름</th>
                    <th>내용</th>
                    <th>가격</th>
                    <th>비고</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($picks as $pick) { ?>
                <tr>
                    <td><img style="width:30px; height:30px;" src="./assets/admin/images/product/<?= $pick["change_photo"] ?>" alt=""></td>
                    <td><?= $pick["name"] ?></td>
                    <td><?= $pick["bio"] ?></td>
                    <td><span id="price"><?= $pick["price"] ?></span>원</td>
                    <td>
                    <a href="detail.php?ccode=<?= $pick["ccode"] ?>&pcode=<?= $pick["pcode"] ?>" class="btn btn-sm btn-success" id="pick_order">구매</a>
                    <button class="btn btn-sm btn-danger" id="pick_delete" data-pcode="<?= $pick["pcode"] ?>">삭제</button>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        
            <!-- FOOTER -->
            <footer class="container">
                    <p class="float-end"><a href="#">Back to top</a></p>
                    <p>&copy; 2017–2022 Company, Inc. &middot; <a href="#">Privacy</a> &middot; <a href="#">Terms</a></p>
            </footer>
        </main>
    </div>
  </body>
</html>