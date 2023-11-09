<?php
# SESSION
include "./inc/session.php";
if ($session_id == "" || $session_role != "A") {
    die("<script>alert('접근 권한이 없습니다.'); self.location.href = './login.php';</script>");
}

# DATABASE
include "../database/database.php";

# CLASS
include "./class/product.php";
include "./class/member.php";
$product = new Product($conn);
$datOfOrders = $product -> getDayOrder();
$product_cnt = $product -> getTotalProduct();
$order_cnt = $product -> getTotalOrder();

$member = new Member($conn);
$member_cnt = $member -> getTotalMember();


# HEADER
$js_array = ["./js/logout.js", "https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js", "./js/chart.js"];
$page_title = "메인";
$page_title_code = "main";
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
                <h1 class="h2">Dashboard</h1>
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

            <div class="row mb-3 text-center">
                <div class="col-sm-4">
                    <div class="card">
                    <div class="card-body">
                        <h3 class="card-title"><?= $product_cnt ?><span class="h5 opacity-50"> EA</span></h3>
                        <p class="card-text text-primary">쇼핑몰 전체 상품 수</p>
                    </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card">
                    <div class="card-body">
                    <h3 class="card-title"><?= $order_cnt["cnt"] ?><span class="h5 opacity-50"> EA</span></h3>
                        <p class="card-text text-danger">쇼핑몰 전체 주문 건 수</p>
                    </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card">
                    <div class="card-body">
                        <h3 class="card-title"><?= $member_cnt ?><span class="h5 opacity-50"> EA</span></h3>
                        <p class="card-text text-success">쇼핑몰 전체 회원 수</p>
                    </div>
                    </div>
                </div>
            </div>

            <!-- chart -->
            <canvas id="chart" width="400" height="100"></canvas>
            <!-- hidden -->
            <?php foreach ($datOfOrders as $order) { ?>
                <input type="hidden" id="create_at" value="<?= $order["create_at"]?>">
                <input type="hidden" id="cnt" value="<?= $order["cnt"]?>">
            <?php } ?>
        </main>
    </div>
  </body>
</html>