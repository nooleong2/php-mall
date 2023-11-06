<?php
// SESSION
include "./inc/session.php";
if ($session_id == "" || $session_role != "A") {
    die("<script>alert('접근 권한이 없습니다.'); self.location.href = './login.php';</script>");
}

// DATABASE
include "../database/database.php";

// HEADER
$js_array = ["./js/product.js"];
$page_title = "상품 관리";
$page_title_code = "product";
include "./inc/header.php";

// CLASS
include "./class/product.php";
$product = new Product($conn);
$products = $product -> getProductAll();
?>
    
    <div class="container-fluid">
        <?php
            # SIDE BAR
            include "./inc/sidebar.php";
        ?>
    
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div
                class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">상품관리</h1>
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

            <table class="table table-hover">
                <colgroup>
                    <col width="3%">
                    <col width="5%">
                    <col width="5%">
                    <col width="5%">
                    <col width="5%">
                    <col width="5%">
                    <col width="5%">
                    <col width="5%">
                    <col width="10%">
                </colgroup>
                <thead>
                    <tr>
                        <th scope="col">번호</th>
                        <th scope="col">이미지</th>
                        <th scope="col">카테고리 코드</th>
                        <th scope="col">상품 코드</th>
                        <th scope="col">상품 이름</th>
                        <th scope="col">가격</th>
                        <th scope="col">상품 수</th>
                        <th scope="col">제조국</th>
                        <th scope="col">비고</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product) { ?>
                    <tr>
                        <td><?= $product["idx"] ?></td>
                        <td><img src="./images/product/<?= $product["change_photo"] ?>" alt="없음" style="width:30px; height:30px;"></td>
                        <td><?= $product["ccode"] ?></td>
                        <td><?= $product["pcode"] ?></td>
                        <td><?= $product["name"] ?></td>
                        <td><?= $product["price"] ?></td>
                        <td><?= $product["cnt"] ?></td>
                        <td><?= $product["country_ko"] ?></td>
                        <td style="cursor: pointer;">
                            <button class="btn btn-success btn-sm" id="modal_open" data-bs-toggle="modal" data-bs-target="#modal" data-pcode="<?= $product["pcode"] ?>">보기</button>
                            <button class="btn btn-warning btn-sm" id="btn_update" data-pcode="<?= $product["pcode"] ?>" data-ccode="<?= $product["ccode"] ?>" data-idx="<?= $product["idx"] ?>">수정</button>
                            <button class="btn btn-danger btn-sm" id="btn_delete" data-idx="<?= $product["idx"] ?>">삭제</button>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <div class="text-end mb-3">
                <button class="btn btn-primary" id="btn_add">추가</button>
            </div>

        </main>
    </div>

    <!-- MODAL -->
    <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modal_title">상품 정보</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <span>상품 이미지</span><br>
                    <img class="mb-3" id="modal_photo" src="" alt="" style="width: 100%;"><br>
                    <span>상품 이름</span><br>
                    <input type="text" class="form-control mb-3" id="name" name="name" readonly>
                    <span>상품 내용</span><br>
                    <input type="text" class="form-control mb-3" id="bio" name="bio" readonly>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">닫기</button>
                </div>
            </div>
        </div>
    </div>


  </body>
</html>