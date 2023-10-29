"use strict";

// 추가 버튼 클릭
const modal_add = document.querySelector("#modal_add");
modal_add.addEventListener("click", () => {
    const modal_title = document.querySelector("#modal_title");
    const mode = document.querySelector("#mode");

    modal_title.textContent = "카테고리 생성";
    mode.value ="add";
});

// 수정 버튼 클릭
const modal_updates = document.querySelectorAll("#modal_update");
modal_updates.forEach((box) => {
    box.addEventListener("click", () => {
        const modal_title = document.querySelector("#modal_title");
        const mode = document.querySelector("#mode");
    
        modal_title.textContent = "카테고리 수정";
        mode.value ="update";
    });
})


// 완료 버튼 클릭 (카테고리 추가, 수정)
const btn_submit = document.querySelector("#btn_submit");
btn_submit.addEventListener("click", () => {
    const mode = document.querySelector("#mode");
    const name = document.querySelector("#name");
    const bio = document.querySelector("#bio");
    const photo = document.querySelector("#photo");

    const f1 = new FormData();

    if (mode.value == "add") {
        f1.append("mode", mode.value);
        f1.append("name", name.value);
        f1.append("bio", bio.value);
        f1.append("photo", photo.files[0]);

        const xhr = new XMLHttpRequest();
        xhr.open("POST", "./process/category_manager_process.php");
        xhr.send(f1);
        xhr.onload = () => {
            if (xhr.status == 200) {
                const data = JSON.parse(xhr.response);
                
                if (data.result == "success_add") {
                    alert("카테고리 추가 성공");
                    self.location.reload();
                }
            } else {
                alert("통신 실패" + xhr.status);
            }
        }
        

    } else if (mode.value == "update") {
        alert("update");
    }
});

// 취소 버튼 클릭
const btn_cancel = document.querySelector("#btn_cancel");
btn_cancel.addEventListener("click", () => {
    const mode = document.querySelector("#mode");
    const name = document.querySelector("#name");
    const bio = document.querySelector("#bio");
    const photo = document.querySelector("#photo");

    mode.value = "";
    name.value = "";
    bio.value = "";
    photo.value = "";
});

 

