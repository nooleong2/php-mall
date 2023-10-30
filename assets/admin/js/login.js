'use strict';

// 로그인 버튼 클릭
const btn_login = document.querySelector("#btn_login");
btn_login.addEventListener("click", () => {
    const id = document.querySelector("#id");
    const password = document.querySelector("#password");

    const f1 = new FormData();
    f1.append("id", id.value);
    f1.append("password", password.value);

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "./process/login_process.php", true);
    xhr.send(f1);
    xhr.onload = () => {
        if (xhr.status == 200) {
            const data = JSON.parse(xhr.response);

            if (data.result == "success_login") {
                alert("로그인 성공했습니다.");
                self.location.href = "./index.php";
            } else if (data.result == "empty_id") {
                alert("아이디를 입력해주시기 바랍니다.");
                id.focus();
            } else if (data.result == "empty_password") {
                alert("비밀번호를 입력해주시기 바랍니다.");
                password.focus();
            }
        } else {
            alert("통신 실패" + xhr.status);
        }
    };
});
