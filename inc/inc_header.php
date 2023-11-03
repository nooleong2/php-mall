<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Shopping mall</title>

    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <?php
        if (isset($css_array)) {
            foreach ($css_array as $css) {
                echo '<link rel="stylesheet" href="' . $css . '">'.PHP_EOL;
            }
        }
    ?>

    <!-- JAVASCRIPT -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <?php
        if (isset($js_array)) {
            foreach ($js_array as $js) {
                echo '<script src="' . $js . '" defer></script>'.PHP_EOL;
            }
        }
    ?>
  </head>
  <body>
    
    <header>
        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="./index.php">Shopping Mall</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"
                    aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <ul class="navbar-nav me-auto mb-2 mb-md-0">
                        <?php foreach ($categorys as $category) { ?>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="./product.php?ccode=<?= $category["ccode"] ?>"><?= $category["name"] ?></a>
                        </li>
                        <?php } ?>
                    </ul>
                    <div>
                        <?php if ( isset($_SESSION["session_id"]) ) { ?>
                            <a class="btn btn-outline-primary" href="./mypage.php">My Page</a>
                            <a class="btn btn-outline-primary" href="./pick.php">찜 목록</a>
                            <a class="btn btn-outline-primary" href="./cart.php">장바구니</a>
                            <a class="btn btn-outline-primary" href="./assets/admin/process/logout_process.php?path=client">로그아웃</a>
                        <?php } else { ?>
                            <a class="btn btn-outline-primary" href="./login.php">로그인</a>
                            <a class="btn btn-outline-primary" href="./stipulation.php">회원가입</a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </nav>
    </header>