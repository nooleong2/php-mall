'use strict';

// 문자열을 숫자형으로 바꾼뒤 toLocaleString() 함수를 통해 천 단위 , 생성
const price = document.querySelector("#price");
const change_price = parseInt(price.textContent).toLocaleString();
price.textContent = change_price;


// 장바구니 추가 버튼 클릭 시
const btn_cart = document.querySelector("#btn_cart");
btn_cart.addEventListener("click", () => {
    const id = document.querySelector("#id");
    const pcode = document.querySelector("#pcode");
    const cnt = document.querySelector("#cnt");

    const f1 = new FormData();
    f1.append("id", id.value);
    f1.append("pcode", pcode.value);
    f1.append("cnt", cnt.value);

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "./process/detail_process.php", true);
    xhr.send(f1);
    xhr.onload = () => {
        if (xhr.status == 200) {
            const data = JSON.parse(xhr.response);

            if (data.result == "empty_info") {
                alert("장바구니 추가 되지 않았습니다.");
            } else if (data.result == "success") {
                alert("장바구니에 상품이 추가되었습니다.");
            }
        } else {
            alert("통신 실패 " + xhr.status);
        }
    }
});
