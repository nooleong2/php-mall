"use strict";

// 추가 버튼 클릭
const modal_add = document.querySelector("#modal_add");
modal_add.addEventListener("click", () => {
    const modal_title = document.querySelector("#modal_title");
    const mode = document.querySelector("#mode");

    modal_title.textContent = "카테고리 생성";
    mode.value = "add";
});

// 수정 버튼 클릭
const modal_updates = document.querySelectorAll("#modal_update");
modal_updates.forEach((box) => {
    box.addEventListener("click", () => {
        const modal_title = document.querySelector("#modal_title");
        const mode = document.querySelector("#mode");
        const idx = document.querySelector("#idx");
        const name = document.querySelector("#name");
        const bio = document.querySelector("#bio");

        const f1 = new FormData();
        f1.append("idx", box.dataset.idx);
        f1.append("mode", "get_info");

        const xhr = new XMLHttpRequest();
        xhr.open("POST", "./process/category_manager_process.php", true);
        xhr.send(f1);
        xhr.onload = () => {
            if (xhr.status == 200) {
                const data = JSON.parse(xhr.response);

                if (data.result == "success_get_info") {

                    idx.value = data.list.idx;
                    name.value = data.list.name;
                    bio.value = data.list.bio;
                }
            } else {
                alert("통신 실패" . xhr.status);
            }
        }
    
        modal_title.textContent = "카테고리 수정";
        mode.value = "update";

    });
})


// 완료 버튼 클릭 (카테고리 추가, 수정)
const btn_submit = document.querySelector("#btn_submit");
btn_submit.addEventListener("click", () => {
    const mode = document.querySelector("#mode");
    const name = document.querySelector("#name");
    const bio = document.querySelector("#bio");
    const photo = document.querySelector("#photo");
    const idx = document.querySelector("#idx");

    const f1 = new FormData();

    if (mode.value == "add") {
        f1.append("mode", mode.value);
        f1.append("name", name.value);
        f1.append("bio", bio.value);
        f1.append("photo", photo.files[0]);

        const xhr = new XMLHttpRequest();
        xhr.open("POST", "./process/category_manager_process.php", true);
        xhr.send(f1);
        xhr.onload = () => {
            if (xhr.status == 200) {
                const data = JSON.parse(xhr.response);
                
                if (data.result == "success_add") {
                    alert("카테고리 추가 성공");
                    self.location.reload();
                } else if (data.result == "empty_name") {
                    alert("카테고리 이름을 작성해주세요");
                    name.focus();
                } else if (data.result == "wrong_type") {
                    alert("지원하는 확장자가 아닙니다.");
                    photo.focus();
                }
            } else {
                alert("통신 실패" + xhr.status);
            }
        }
        

    } else if (mode.value == "update") {

        f1.append("mode", mode.value);
        f1.append("idx", idx.value);
        f1.append("name", name.value);
        f1.append("bio", bio.value);
        f1.append("photo", photo.files[0]);

        const xhr = new XMLHttpRequest();
        xhr.open("POST", "./process/category_manager_process.php", true);
        xhr.send(f1);
        xhr.onload = () => {
            if (xhr.status == 200) {
                const data = JSON.parse(xhr.response);

                if (data.result == "success_update") {
                    alert("카테고리 수정되었습니다.");
                    self.location.reload();
                } else if (data.result == "empty_name") {
                    alert("카테고리 이름을 작성해주세요.");
                    name.focus();
                } else if (data.result == "empty_idx") {
                    alert("카테고리 번호가 존재하지 않습니다.");
                    self.location.href = "./category_manager.php";
                } else if (data.result == "wrong_type") {
                    alert("지원하는 확장자가 아닙니다.");
                    photo.focus();
                }
            } else {
                alert("통신 실패" + xhr.status);
            }
        }
        
    }
});

// 삭제 버튼 클릭
const btn_deletes = document.querySelectorAll("#btn_delete");
btn_deletes.forEach((box) => {
    box.addEventListener("click", () => {
        if (confirm("해당 카테고리를 정말로 삭제하시겠습니까?")) {
            const idx = box.dataset.idx;

            const f1 = new FormData();
            f1.append("idx", idx);
            f1.append("mode", "delete");

            const xhr = new XMLHttpRequest();
            xhr.open("POST", "./process/category_manager_process.php", true);
            xhr.send(f1);
            xhr.onload = () => {
                if (xhr.status == 200) {
                    const data = JSON.parse(xhr.response);

                    if (data.result == "success_delete") {
                        self.location.reload();
                    } else if (data.result == "empty_idx") {
                        alert("카테고리 번호가 존재하지 않습니다.");
                        self.location.href = "./category_manager.php";
                    }
                } else {
                    alert("통신 실패" + xhr.status);
                }
            }
        }
    });
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

 

