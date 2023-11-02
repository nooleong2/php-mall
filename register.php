<?php
if (!isset($_POST["chk"]) || $_POST["chk"] != 1) {
    echo "<script>alert('접근 권한이 없습니다.'); self.location.href = './stipulation.php';</script>";
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>회원가입</title>
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <!-- JAVASCRIPT -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous" defer></script>
    <script src="./js/register.js" defer></script>

    <!-- 카카오 우편 찾기 API -->
    <script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
  </head>
  <body>

  <main class="m-5 w-50 mx-auto p-5 border rounded-5">
    <h1 class="text-center">회원가입</h1>

    <form autocomplete="off">

        <!-- 중복 체크 -->
        <input type="hidden" id="valid_id" value="0">
        <input type="hidden" id="valid_email" value="0">

        <!-- 아이디 --> 
        <div class="d-flex gap-2 align-items-end">
            <div class="flex-grow-1">
                <label for="id" class="form-label">아이디*</label>
                <input type="text" class="form-control" name="id" id="id" placeholder="아이디를 입력해주세요.">
            </div>
            <button type="button" class="btn btn-secondary" name="btn_chk_id" id="btn_chk_id">아이디 중복확인</button>
        </div>

        <!-- 비밀번호 -->
        <div class="d-flex mt-3 gap-2 justify-content-between">
            <div class="flex-grow-1">
                <label for="password1" class="form-label">비밀번호*</label>
                <input type="password" class="form-control" name="password1" id="password1" placeholder="비밀번호를 입력해주세요.">
            </div>
            <div class="flex-grow-1">
                <label for="password2" class="form-label">비밀번호 확인</label>
                <input type="password" class="form-control" name="password2" id="password2" placeholder="비밀번호를 입력해주세요.">
            </div>
        </div>

        <!-- 이메일 --> 
        <div class="d-flex mt-3 gap-2 align-items-end">
            <div class="flex-grow-1">
                <label for="email" class="form-label">이메일*</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="이메일을 입력해주세요.">
            </div>
            <button type="button" class="btn btn-secondary" id="btn_chk_email">이메일 중복확인</button>
        </div>

        <!-- 이름 --> 
        <div class="d-flex mt-3 gap-2 align-items-end">
            <div class="w-50">
                <label for="name" class="form-label">이름*</label>
                <input type="text" class="form-control" name="name" id="name" placeholder="이름을 입력해주세요.">
            </div>
        </div>

        <!-- 우편번호 찾기 -->
        <div class="mt-3 d-flex align-items-end gap-2">
            <div>
                <label for="zipcode">우편번호</label>
                <input type="text" name="zipcode" id="zipcode" class="form-control" maxlength="5" minlength="5">
            </div>
            <button type="button" class="btn btn-secondary" id="btn_search_zip">우편번호 찾기</button>
        </div>

        <!-- 주소 / 상세주소 -->
        <div class="d-flex mt-3 gap-2 justify-content-between">
            <div class="flex-grow-1">
                <label for="addr1" class="form-label">주소</label>
                <input type="text" class="form-control" name="addr1" id="addr1">
            </div>
            <div class="flex-grow-1">
                <label for="addr2" class="form-label">상세 주소</label>
                <input type="text" class="form-control" name="addr2" id="addr2">
            </div>
        </div>

        <!-- 프로필 이미지 -->
        <div class="mt-3 d-flex gap-5">
            <div>
                <label for="photo">프로필 이미지</label>
                <input type="file" name="photo" class="form-control" id="photo">
            </div>
            <img src="./images/default.png" id="preview" alt="profile image" class="w-25">
        </div>

        <!-- 버튼 -->
        <div class="mt-3 d-flex gap-2">
            <button type="button" class="btn btn-primary w-50" id="btn_submit">가입하기</button>
            <button type="button" class="btn btn-secondary w-50">가입취소</button>
        </div>
    </form>

</main>
    
  </body>
</html>