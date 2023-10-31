'use strict';

// 수정 버튼 클릭
const btn_updates = document.querySelectorAll("#btn_update");
btn_updates.forEach((box) => {
    box.addEventListener("click", () => {
        alert("update");
    });
});

// 삭제 버튼 클릭
const btn_deletes = document.querySelectorAll("#btn_delete");
btn_deletes.forEach((box) => {
    box.addEventListener("click", () => {
        alert("delete");
    });
});

// 모달 오픈 버튼 클릭
const modal_opens = document.querySelectorAll("#modal_open");
modal_opens.forEach((box) => {
    box.addEventListener("click", () =>{
        
        const f1 = new FormData();
        const pcode = box.dataset.pcode;
        f1.append("pcode", pcode);

        const xhr = new XMLHttpRequest();
        xhr.open("POST", "./process/product_process.php", true);
        xhr.send(f1);
        xhr.onload = () => {
            if (xhr.status == 200) {
                const data = JSON.parse(xhr.response);

                if (data.result == "empty_pcode") {
                    alert("상품 코드가 존재하지 않습니다.");
                    return false;
                } else if (data.result == "success_get") {
                    const name = document.querySelector("#name");
                    const bio = document.querySelector("#bio");

                    name.value = data.list.name;
                    bio.value = data.list.bio;
                }
            } else {
                alert("통신 실패" + xhr.status);
            }
        }
        
    });
});

// 추가 버튼 클릭
const btn_add = document.querySelector("#btn_add");
btn_add.addEventListener("click", () => {
    self.location.href = "./product_write.php";
});
