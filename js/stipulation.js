'use strict';

const btn_register = document.querySelector("#btn_register");
btn_register.addEventListener("click", () => {
    const chk_member1 = document.querySelector("#chk_member1");
    const chk_member2 = document.querySelector("#chk_member2");

    if (chk_member1.checked != true) {
        alert("회원 약관 동의가 필요합니다.");
        chk_member1.focus();
        return;
    }

    if (chk_member2.checked != true) {
        alert("개인정보 취급 방침 동의가 필요합니다.");
        chk_member2.focus();
        return;
    }

    const f1 = document.stipulation_form;
    f1.chk.value = 1;
    f1.submit();

});

