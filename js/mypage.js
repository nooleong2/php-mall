'use strict';

const photo = document.querySelector("#photo");
photo.addEventListener("change", (e) => {
    
    const reader = new FileReader();
    reader.readAsDataURL(e.target.files[0]);
    reader.onload = (e) => {
        const preview = document.querySelector("#preview");
        preview.setAttribute("src", e.target.result);
    }
    
});

const btn_update = document.querySelector("#btn_update");
btn_update.addEventListener("click", () => {
    
    const id = document.querySelector("#id");
    const password = document.querySelector("#password");
    const name = document.querySelector("#name");
    const zipcode = document.querySelector("#zipcode");
    const addr1 = document.querySelector("#addr1");
    const addr2 = document.querySelector("#addr2");
    const photo = document.querySelector("#photo");

    const f1 = new FormData();
    f1.append("id", id.value);
    f1.append("password", password.value);
    f1.append("name", name.value);
    f1.append("zipcode", zipcode.value);
    f1.append("addr1", addr1.value);
    f1.append("addr2", addr2.value);
    f1.append("photo", photo.files[0]);

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "./process/mypage_process.php", true);
    xhr.send(f1);
    xhr.onload = () => {
        if (xhr.status == 200) {
            const data = JSON.parse(xhr.response);

            if (data.result == "empty_id") {
                alert("아이디가 비어있습니다.");
            } else if (data.result == "wrong_type") {
                alert("지원하지 않는 파일 형식입니다.");
                photo.focus();
            } else if (data.result == "success") {
                alert("회원 수정이 완료되었습니다.");
                self.location.reload();
            }
        } else {
            alert("통신 실패 " + xhr.status);
        }
    }
    
});