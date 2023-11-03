<?php
// SESSION
include "./assets/admin/inc/session.php";

// DATABASE
include "./assets/database/database.php";

// CLASS
include "./assets/admin/class/category_manager.php";
include "./assets/admin/class/member.php";
$cm = new CategoryManager($conn);
$member = new Member($conn);

$categorys = $cm -> getCategoryAll();
$mem = $member -> getMemberInfo($session_id);

// HEADER
$js_array = ["./js/mypage.js"];
include "./inc/inc_header.php";
?>

<main class="m-5 w-50 mx-auto p-5 border rounded-5">
    <h1 class="text-center">회원 정보</h1>

    <form autocomplete="off">

        <!-- 중복 체크 -->
        <input type="hidden" id="valid_id" value="0">
        <input type="hidden" id="valid_email" value="0">

        <!-- 아이디 --> 
        <div class="d-flex gap-2 align-items-end">
            <div class="flex-grow-1">
                <label for="id" class="form-label">아이디</label>
                <input type="text" class="form-control" name="id" id="id" value="<?= $mem["id"] ?>" placeholder="아이디를 입력해주세요." readonly>
            </div>
        </div>

        <!-- 비밀번호 -->
        <div class="d-flex mt-3 gap-2 justify-content-between">
            <div class="flex-grow-1">
                <label for="password" class="form-label">비밀번호</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="비밀번호를 입력해주세요.">
            </div>
        </div>

        <!-- 이메일 --> 
        <div class="d-flex mt-3 gap-2 align-items-end">
            <div class="flex-grow-1">
                <label for="email" class="form-label">이메일</label>
                <input type="email" class="form-control" name="email" id="email" value="<?= $mem["email"] ?>" placeholder="이메일을 입력해주세요." readonly>
            </div>
        </div>

        <!-- 이름 --> 
        <div class="d-flex mt-3 gap-2 align-items-end">
            <div class="w-50">
                <label for="name" class="form-label">이름</label>
                <input type="text" class="form-control" name="name" id="name" value="<?= $mem["name"] ?>" placeholder="이름을 입력해주세요.">
            </div>
        </div>

        <!-- 우편번호 찾기 -->
        <div class="mt-3 d-flex align-items-end gap-2">
            <div>
                <label for="zipcode">우편번호</label>
                <input type="text" name="zipcode" id="zipcode" class="form-control" value="<?= $mem["zipcode"] ?>" maxlength="5" minlength="5">
            </div>
            <button type="button" class="btn btn-secondary" id="btn_search_zip">우편번호 찾기</button>
        </div>

        <!-- 주소 / 상세주소 -->
        <div class="d-flex mt-3 gap-2 justify-content-between">
            <div class="flex-grow-1">
                <label for="addr1" class="form-label">주소</label>
                <input type="text" class="form-control" name="addr1" id="addr1"  value="<?= $mem["addr1"] ?>">
            </div>
            <div class="flex-grow-1">
                <label for="addr2" class="form-label">상세 주소</label>
                <input type="text" class="form-control" name="addr2" id="addr2"  value="<?= $mem["addr2"] ?>">
            </div>
        </div>

        <!-- 프로필 이미지 -->
        <div class="mt-3 d-flex gap-5">
            <div>
                <label for="photo">프로필 이미지</label>
                <input type="file" name="photo" class="form-control" id="photo">
            </div>
            <img src="./images/<?= $mem["change_photo"] ?>" id="preview" alt="profile image" class="w-25">
        </div>

        <!-- 버튼 -->
        <div class="mt-3 d-flex gap-2">
            <button type="button" class="btn btn-primary w-50" id="btn_update">수정하기</button>
            <a href="./index.php" type="button" class="btn btn-secondary w-50">수정취소</a>
        </div>
    </form>

</main>
  </body>
</html>