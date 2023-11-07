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
include "./assets/admin/class/member.php";
$cm = new CategoryManager($conn);
$categorys = $cm -> getCategoryAll();

$m = new Member($conn);
$member = $m -> getMemberInfo($session_id);

$pd = new Product($conn);
$products = $pd -> getCartProduct($session_id);
// HEADER
$js_array = ["./js/cart.js", "https://cdn.iamport.kr/js/iamport.payment-1.1.5.js", "https://code.jquery.com/jquery-3.7.1.min.js", "//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"];
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
                <!-- HIDDEN -->
                <input type="hidden" id="m_id" value="<?= isset($session_id) ? $session_id : "";  ?>">
                <input type="hidden" id="m_name" value="<?= isset($member["name"]) ? $member["name"] : ""; ?>">
                <input type="hidden" id="m_email" value="<?= isset($member["email"]) ? $member["email"] : ""; ?>">
                <input type="hidden" id="m_zipcode" value="<?= isset($member["zipcode"]) ? $member["zipcode"] : ""; ?>">
                <input type="hidden" id="m_addr1" value="<?= isset($member["addr1"]) ? $member["addr1"] : ""; ?>">
                <input type="hidden" id="m_addr2" value="<?= isset($member["addr2"]) ? $member["addr2"] : ""; ?>">
                <?php foreach ($products as $product) { ?>
                    <input type="hidden" id="p_code" value="<?= isset($product["pcode"]) ? $product["pcode"] : ""; ?>">
                    <input type="hidden" id="og_price" value="<?= $product["price"] ?>">
                    <input type="hidden" id="og_cnt" value="<?= $product["cnt"] ?>">
                <tr>
                    <td id="idx"><?= $product["idx"] ?></td>
                    <td><img src="./assets/admin/images/product/<?= $product["change_photo"] ?>" alt="" style="width:40px; height:40px;"></td>
                    <td id="pname"><?= $product["name"] ?></td>
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
            <button class="btn btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" id="btn_order_modal">구매하기</button>
        </div>
            
        </div>

        <footer class="container my-5">
            <p class="float-end"><a href="#">Back to top</a></p>
            <p>&copy; 2017–2022 Company, Inc. &middot; <a href="#">Privacy</a> &middot; <a href="#">Terms</a></p>
    </footer>
    </main>

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