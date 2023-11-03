'use strict';

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

// 찜 버튼 클릭 시 이벤트
const btn_pick = document.querySelectorAll("#btn_pick");
btn_pick.forEach((box) => {
    box.addEventListener("click", () => {
        const id = document.querySelector("#session_id");
        const pcode = box.dataset.pcode;

        const f1 = new FormData();
        f1.append("id", id.value);
        f1.append("pcode", pcode);
        f1.append("mode", "add");

        const xhr = new XMLHttpRequest();
        xhr.open("POST", "./process/pick_process.php", true);
        xhr.send(f1);
        xhr.onload = () => {
            if (xhr.status == 200) {
                const data = JSON.parse(xhr.response);

                if (data.result == "empty_info") {
                    alert("상품 정보가 존재하지 않습니다.");
                } else if (data.result == "success") {
                    alert("찜 목록에 추가되었습니다.");
                } else if (data.result == "already_pick") {
                    alert("이미 찜한 상품입니다.");
                } 
            } else {
                alert("통신 실패 " + xhr.status);
            }
        }
    });
});
