'use strict';

// 아이디 체크 버튼 클릭 시 이벤트 발생
const btn_chk_id = document.querySelector("#btn_chk_id");
btn_chk_id.addEventListener("click", () => {

    const id = document.querySelector("#id");

    if (id.value == "") {
        alert("아이디 값을 입력해주시기 바랍니다.");
        id.focus();
        return;
    }

    const f1 = new FormData();
    f1.append("id", id.value);
    f1.append("valid", "id");

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "./process/register_process.php", true);
    xhr.send(f1);
    xhr.onload = () => {
        if (xhr.status == 200) {
            const data = JSON.parse(xhr.response);

            if (data.result == "empty_id") {
                alert("아이디를 입력해주시기 바랍니다.");
                id.focus();
            } else if (data.result == "already_param") {
                alert("사용할 수 없는 아이디입니다.");
                id.value = "";
                id.focus();
            } else if (data.result == "success") {
                alert("사용 가능한 아이디 입니다.");
                document.querySelector("#valid_id").value = "1";
                document.querySelector("#password1").focus();
            }
        } else {
            alert("통신 실패 " + xhr.status);
        }
    }
});

// 이메일 체크 버튼 클릭 시 이벤트 발생
const btn_chk_email = document.querySelector("#btn_chk_email");
btn_chk_email.addEventListener("click", () => {

    const email = document.querySelector("#email");

    if (email.value == "") {
        alert("이메일 값을 입력해주시기 바랍니다.");
        email.focus();
        return;
    }

    const f1 = new FormData();
    f1.append("email", email.value);
    f1.append("valid", "email");

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "./process/register_process.php", true);
    xhr.send(f1);
    xhr.onload = () => {
        if (xhr.status == 200) {
            const data = JSON.parse(xhr.response);

            if (data.result == "empty_email") {
                alert("이메일을 입력해주시기 바랍니다.");
                email.focus();
            } else if (data.result == "already_param") {
                alert("존재하는 이메일입니다.");
                email.value = "";
                email.focus();
            } else if (data.result == "success") {
                alert("사용 가능한 이메일 입니다.");
                document.querySelector("#valid_email").value = "1";
                document.querySelector("#name").focus();
            }
        } else {
            alert("통신 실패 " + xhr.status);
        }
    }
});


// 우편찾기 버튼 클릭 시 이벤트 발생
const btn_search_zip = document.querySelector("#btn_search_zip");
btn_search_zip.addEventListener("click", () => {
    // 카카오 우편 찾기 API
    new daum.Postcode({
        oncomplete: function(data) {
            let addr = ""; // 주소
            let extra_arr = ""; // 법정동

            if (data.userSelectedType == "J") {
                // 지번 == J
                addr = data.jibunAddress;
            } else if (data.userSelectedType == "R") {
                // 도로명 == R
                addr = data.roadAddress;
            }

            // 법정동
            if (data.bname != "") {
                extra_arr = data.bname;
            }

            // 건물 이름
            if (data.buildingName != "") {
                if (extra_arr == "") {
                    extra_arr = data.buildingName;
                } else {
                    extra_arr += ', ' + data.buildingName;
                }   
            }

            if (extra_arr != "") {
                extra_arr = " (" + extra_arr + ")";
            }

            const addr1 = document.querySelector("#addr1");
            const addr2 = document.querySelector("#addr2");
            const zipcode = document.querySelector("#zipcode");
            addr1.value = addr + extra_arr;
            zipcode.value = data.zonecode;
            addr2.focus();

        }
    }).open();
});

// 이미지 추가 버튼 클릭 시 이벤트
const photo = document.querySelector("#photo");
photo.addEventListener("change", (e) => {
    e.preventDefault();

    const reader = new FileReader();
    reader.readAsDataURL(e.target.files[0]);
    reader.onload = (e) => {
        const preview = document.querySelector("#preview");
        preview.setAttribute("src", e.target.result);
    }
});

// 회원가입 버튼 클릭 시 이벤트 발생
const btn_submit = document.querySelector("#btn_submit");
btn_submit.addEventListener("click", () => {

    const id = document.querySelector("#id");
    const password1 = document.querySelector("#password1");
    const password2 = document.querySelector("#password2");
    const email = document.querySelector("#email");
    const name = document.querySelector("#name");
    const zipcode = document.querySelector("#zipcode");
    const addr1 = document.querySelector("#addr1");
    const addr2 = document.querySelector("#addr2");
    const photo = document.querySelector("#photo");

    if (id.value == "") {
        alert("아이디를 입력해주시기 바랍니다.");
        id.focus();
        return;
    }

    if (password1.value == "") {
        alert("비밀번호를 입력 하지 않았습니다.");
        password1.focus();
        return;
    } else if (password2.value == "") {
        alert("비밀번호 확인을 입력하지 않습니다.");
        password2.focus();
        return;
    } else if (password2.value != password1.value) {
        password2.focus();
        alert("비밀번호가 일치하지 않습니다.");
        return;
    }

    if (email.value == "") {
        alert("이메일을 입력해주시기 바랍니다.");
        email.focus();
        return;
    }

    if (name.value == "") {
        alert("이름을 입력해주시기 바랍니다.");
        email.focus();
        return;
    }

    const valid_id = document.querySelector("#valid_id");
    const valid_email = document.querySelector("#valid_email");
    if (valid_id.value != 1) {
        alert("아이디 중복 체크 해주시기 바랍니다.");
        return;
    }

    if (valid_email.value != 1) {
        alert("이메일 중복 체크 해주시기 바랍니다");
        return;
    }

    const f1 = new FormData();
    f1.append("id", id.value);
    f1.append("password", password1.value);
    f1.append("email", email.value);
    f1.append("name", name.value);
    f1.append("zipcode", zipcode.value);
    f1.append("addr1", addr1.value);
    f1.append("addr2", addr2.value);
    f1.append("photo", photo.files[0]);
    
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "./process/register_process.php", true);
    xhr.send(f1);
    xhr.onload = () => {
        if (xhr.status == 200) {
            const data = JSON.parse(xhr.response);

            if (data.result == "empty_id") {
                alert("Back : 아이디가 존재하지 않습니다.");
                id.focus();
            } else if (data.result == "empty_password") {
                alert("Back : 비밀번호가 존재하지 않습니다.");
                password1.focus();
            } else if (data.result == "empty_email") {
                alert("Back : 이메일이 존재하지 않습니다.");
                email.focus();
            } else if (data.result == "empty_name") {
                alert("Back : 이름이 존재하지 않습니다.");
                name.focus();
            } else if (data.result == "success") {
                alert("회원가입이 완료되었습니다.");
                self.location.href = "./index.php";
            }
        } else {
            alert("통신 실패 " + xhr.status);
        }
    }
});