<?php
# DATABASE
include "../database/database.php";

# HEADER
$js_array = ["./js/category_manager.js"];
$page_title = "카테고리 관리";
include "./inc/header.php";

# CLASS
include "./class/category_manager.php";
$category = new CategoryManager($conn);
$categoryAll = $category -> getCategoryAll();
?>
    
    <div class="container-fluid">
        <?php
            # SIDE BAR
            include "./inc/sidebar.php";
        ?>
    
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <!-- SECTION 1 -->
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">카테고리 관리</h1>
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

                <!-- SECTION 2 -->
                <div class="text-center">
                    <div class="row align-items-start">
                        <?php foreach ($categoryAll as $category) {?>
                        <div class="col-4 shadow-sm mt-3 rounded-2 bg-opacity-25 p-3">
                            <h3>이름: <?= $category["name"] ?></h3>
                            <h6>코드: <?= $category["ccode"] ?></h6>
                            <hr>
                            <p>내용: <?= $category["bio"] ?></p>
                            <hr>
                            <div class="text-end">
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modal" data-idx="<?= $category["idx"] ?>" id="modal_update">수정</button>
                                <button class="btn btn-danger btn-sm">삭제</button>
                            </div>
                        </div>
                        <?php }?>
                    </div>
                </div>

                <div class="mt-3 text-end">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal" id="modal_add">추가</button>
                </div>
    
            </main>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="modal_title">모달</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <input type="text" id="mode" name="mode" value="" readonly>
            <span>카테고리 이름</span><br>
            <input type="text" class="form-control" id="name" name="name">
            <span>카테고리 내용</span><br>
            <input type="text" class="form-control" id="bio" name="bio">
            <span>카테고리 이미지</span><br>
            <input type="file" class="form-control" id="photo" name="photo">
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btn_cancel">취소</button>
            <button type="button" class="btn btn-primary" id="btn_submit">완료</button>
        </div>
        </div>
    </div>
    </div>

  </body>
</html>