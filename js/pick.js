'use strict';

const price = document.querySelectorAll("#price");

// 천 단위 콤마 생성
for (let i = 0; i < price.length; i++) {

    // 문자열을 숫자형으로 바꾼뒤 toLocaleString() 함수를 통해 천 단위 , 생성
    const change_price = parseInt(price[i].textContent).toLocaleString();

    price[i].textContent = change_price;
}

// 찜 상품 삭제
const pick_delete = document.querySelectorAll("#pick_delete");
pick_delete.forEach((box) => {
    box.addEventListener("click", () => {
        if (confirm("해당 찜 상품을 삭제하시겠습니까?")) {
            const f1 = new FormData();
            f1.append("pcode", box.dataset.pcode);
            f1.append("mode", "delete");
    
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "./process/pick_process.php", true);
            xhr.send(f1);
            xhr.onload = () => {
                if (xhr.status == 200) {
                    const data = JSON.parse(xhr.response);
    
                    if (data.result == "empty_pcode") {
                        alert("찜 삭제에 실패했습니다.");
                    } else if (data.result == "success") {
                        self.location.reload();
                    }
                } else {
                    alert("통신 실패 " + xhr.status);
                }
            }
        }
    });
});