<?php
# SESSION
include "./inc/session.php";
if ($session_id == "" || $session_role != "A") {
    die("<script>alert('접근 권한이 없습니다.'); self.location.href = './login.php';</script>");
}

// DATABASE
include "../database/database.php";

// CLASS
include "./class/product.php";
$product = new Product($conn);
$orders = $product -> getOrders();

# HEADER
$js_array = ["./js/excel.js"];
$page_title = "주문 관리";
$page_title_code = "order";
include "./inc/header.php";

?>
    
    <div class="container-fluid">
        <?php
            # SIDE BAR
            include "./inc/sidebar.php";
        ?>
    
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

            <div
                class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">주문 관리</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <button type="button" class="btn btn-sm btn-outline-secondary" id="btn_order_excel">엑셀 다운로드</button>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
                        <span data-feather="calendar" class="align-text-bottom"></span>
                        This week
                    </button>
                </div>
            </div>

            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">순번</th>
                        <th scope="col">주문 번호</th>
                        <th scope="col">주문자</th>
                        <th scope="col">상품명</th>
                        <th scope="col">개당 가격</th>
                        <th scope="col">구매 상품 수</th>
                        <th scope="col">토탈 가격</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order) { ?>
                    <tr>
                        <td><?= $order["idx"] ?></td>
                        <td><?= $order["order_uid"] ?></td>
                        <td><?= $order["m_name"] ?></td>
                        <td><?= $order["p_name"] ?></td>
                        <td><?= $order["p_one_price"] ?></td>
                        <td><?= $order["p_cnt"] ?></td>
                        <td><?= $order["p_total_price"] ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>

        </main>
    </div>

  </body>
</html>