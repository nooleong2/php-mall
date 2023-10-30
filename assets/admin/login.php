<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>관리자 로그인</title>
    
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="./css/login.css" rel="stylesheet">

    <!-- JAVASCRIPT -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="./js/login.js" defer></script>
  </head>
  <body class="text-center">

    <main class="form-signin w-100 m-auto">
      <form autocomplete="off">
        <img class="mb-4" src="https://getbootstrap.com/docs/5.2/assets/brand/bootstrap-logo.svg" alt="" width="72"
          height="57">
        <h1 class="h3 mb-3 fw-normal">로그인</h1>
    
        <div class="form-floating">
          <input type="text" class="form-control" id="id" name="id">
          <label for="id">아이디</label>
        </div>
        <div class="form-floating">
          <input type="password" class="form-control" id="password" name="password">
          <label for="password">비밀번호</label>
        </div>
    
        <button class="w-100 btn btn-lg btn-primary" type="button" id="btn_login">로그인</button>
        <p class="mt-5 mb-3 text-muted">&copy;nooleong2 2023</p>
      </form>
    </main>

  </body>
</html>