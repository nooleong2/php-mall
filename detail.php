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
include "./assets/admin/class/member.php";
$cm = new CategoryManager($conn);
$categorys = $cm -> getCategoryAll();

$pd = new Product($conn);
$product = $pd -> getProductFromPcode($pcode);

$m = new Member($conn);
$member = $m -> getMemberInfo($session_id);

// HEADER
$js_array = ["./js/detail.js", "https://cdn.iamport.kr/js/iamport.payment-1.1.5.js", "https://code.jquery.com/jquery-3.7.1.min.js", "//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"];
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
                    <!-- HIDDEN -->
                    <input type="hidden" id="m_id" value="<?= isset($session_id) ? $session_id : "";  ?>">
                    <input type="hidden" id="m_name" value="<?= isset($member["name"]) ? $member["name"] : ""; ?>">
                    <input type="hidden" id="m_email" value="<?= isset($member["email"]) ? $member["email"] : ""; ?>">
                    <input type="hidden" id="m_zipcode" value="<?= isset($member["zipcode"]) ? $member["zipcode"] : ""; ?>">
                    <input type="hidden" id="m_addr1" value="<?= isset($member["addr1"]) ? $member["addr1"] : ""; ?>">
                    <input type="hidden" id="m_addr2" value="<?= isset($member["addr2"]) ? $member["addr2"] : ""; ?>">

                    <input type="hidden" id="p_code" value="<?= $product["pcode"] ?>">
                    <h3 class="mb-3">상품명: <span id="p_name"><?= $product["name"] ?></span></h3>
                    <div class="mb-3 text-danger">가격: <span id="p_one_price"><?= $product["price"] ?></span>원</div>
                    <div>
                        개수: <input id="p_cnt" class="mb-3" type="number" min="1" max="999" value="1" maxlength="3">
                    </div>
                    <p class="card-text mb-3">내용: <?= $product["bio"] ?></p>
                    <hr>
                    <div class="h3 text-danger text-end mb-3">총 금액: <span id="p_total_price"></span>원</div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-outline-primary w-50" data-bs-toggle="modal" data-bs-target="#exampleModal" id="btn_order_modal">구매하기</button>
                        <button class="btn btn-outline-danger w-50" onclick="history.go(-1);">뒤로가기</button>
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

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">상품 주문</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- 이름 --> 
        <div class="d-flex mt-3 gap-2 align-items-end">
            <div class="w-50">
                <label for="modal_m_name" class="form-label">이름</label>
                <input type="text" class="form-control" name="modal_m_name" id="modal_m_name" placeholder="이름을 입력해주세요.">
            </div>
        </div>

        <!-- 이름 --> 
        <div class="d-flex mt-3 gap-2 align-items-end">
            <div class="w-50">
                <label for="modal_m_phone" class="form-label">휴대폰 번호</label>
                <input type="text" class="form-control" name="modal_m_phone" id="modal_m_phone" placeholder="휴대폰 번호입력 - 없이">
            </div>
        </div>

        <!-- 이메일 --> 
        <div class="d-flex mt-3 gap-2 align-items-end">
            <div class="flex-grow-1">
                <label for="modal_m_email" class="form-label">이메일</label>
                <input type="email" class="form-control" name="modal_m_email" id="modal_m_email" placeholder="이메일을 입력해주세요.">
            </div>
        </div>

        <!-- 우편번호 찾기 -->
        <div class="mt-3 d-flex align-items-end gap-2">
            <div>
                <label for="modal_m_zipcode">우편번호</label>
                <input type="text" name="modal_m_zipcode" id="modal_m_zipcode" class="form-control" maxlength="5" minlength="5">
            </div>
            <button type="button" class="btn btn-secondary" id="btn_search_zip">우편번호 찾기</button>
        </div>

        <!-- 주소 / 상세주소 -->
        <div class="d-flex my-3 gap-2 justify-content-between">
            <div class="flex-grow-1">
                <label for="modal_m_addr1" class="form-label">주소</label>
                <input type="text" class="form-control" name="modal_m_addr1" id="modal_m_addr1">
            </div>
            <div class="flex-grow-1">
                <label for="modal_m_addr2" class="form-label">상세 주소</label>
                <input type="text" class="form-control" name="modal_m_addr2" id="modal_m_addr2">
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="btn_order">주문하기</button>
      </div>
    </div>
  </div>
</div>

</body>
</html>

