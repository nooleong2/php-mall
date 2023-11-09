<?php
# SESSION
include "./inc/session.php";
if ($session_id == "" || $session_role != "A") {
    die("<script>alert('접근 권한이 없습니다.'); self.location.href = './login.php';</script>");
}

// DATABASE
include "../database/database.php";

// CLASS
include "./class/member.php";
$member = new Member($conn);
$members = $member -> getMemberAll();

# HEADER
$js_array = ["./js/excel.js"];
$page_title = "회원 관리";
$page_title_code = "member";
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
                <h1 class="h2">회원 관리</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <!-- <div class="btn-group me-2">
                        <button type="button" class="btn btn-sm btn-success" id="btn_order_excel">엑셀 다운로드</button>
                    </div> -->
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
                        <th scope="col">프로필</th>
                        <th scope="col">아이디</th>
                        <th scope="col">이름</th>
                        <th scope="col">이메일</th>
                        <th scope="col">등급</th>
                        <th scope="col">가입 일자</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($members as $member) { ?>
                    <tr>
                        <td><?= $member["idx"] ?></td>
                        <?php if ($member["change_photo"]) { ?>
                            <td><img src="../../images/<?= $member["change_photo"] ?>" alt="" width="30px" height="30px"></td>
                        <?php } else { ?>
                            <td><img src="../../images/default.png" alt="" width="30px" height="30px"></td>
                        <?php } ?>
                        <td><?= $member["id"] ?></td>
                        <td><?= $member["name"] ?></td>
                        <td><?= $member["email"] ?></td>
                        <td><?= $member["role"] ?></td>
                        <td><?= $member["create_at"] ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>

        </main>
    </div>

  </body>
</html>