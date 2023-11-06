'use strict';

const idx = document.querySelectorAll("#idx");
const og_price = document.querySelectorAll("#og_price");
const og_cnt = document.querySelectorAll("#og_cnt");
const price = document.querySelectorAll("#price");
const cnt = document.querySelectorAll("#cnt");

// 천 단위 콤마 생성
for (let i = 0; i < price.length; i++) {

    // 문자열을 숫자형으로 바꾼뒤 toLocaleString() 함수를 통해 천 단위 , 생성
    const change_price = parseInt(price[i].textContent).toLocaleString();
    const change_cnt = parseInt(cnt[i].textContent).toLocaleString();

    price[i].textContent = change_price;
    cnt[i].textContent = change_cnt;

}

// 총 금액
let tprice = 0;
for (let i = 0; i < idx.length; i++) {
    const multiPrice = og_price[i].value * og_cnt[i].value;
    tprice += multiPrice;
}

const total_price = document.querySelector("#total_price");
total_price.textContent = tprice.toLocaleString();

// 카트 상품 삭제
const btn_deletes = document.querySelectorAll("#btn_delete");
btn_deletes.forEach((box) => {
    box.addEventListener("click", () => {
        if (confirm("해당 상품을 장바구니에서 제거하시겠습니까?")) {
            const f1 = new FormData();
            f1.append("idx", box.dataset.idx);
    
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "./process/cart_process.php", true);
            xhr.send(f1);
            xhr.onload = () => {
                if (xhr.status == 200) {
                    const data = JSON.parse(xhr.response);
    
                    if (data.result == "empty_idx") {
                        alert("장바구니 번호가 없습니다.");
                    } else {
                        self.location.reload();
                    }
                } else {
                    alert("통신 실패 " + xhr.status);
                }
            }
        }
    });
});
