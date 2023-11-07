'use strict';

const idx = document.querySelectorAll("#idx");
const og_price = document.querySelectorAll("#og_price");
const og_cnt = document.querySelectorAll("#og_cnt");
const pname = document.querySelectorAll("#pname");
const price = document.querySelectorAll("#price");
const cnt = document.querySelectorAll("#cnt");
const p_code = document.querySelectorAll("#p_code");

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
            f1.append("mode", "delete");
    
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

// 모달 input
const m_id = document.querySelector("#m_id"); // 세션 아이디
const modal_m_name = document.querySelector("#modal_m_name");
const modal_m_email = document.querySelector("#modal_m_email");
const modal_m_phone = document.querySelector("#modal_m_phone");
const modal_m_zipcode = document.querySelector("#modal_m_zipcode");
const modal_m_addr1 = document.querySelector("#modal_m_addr1");
const modal_m_addr2 = document.querySelector("#modal_m_addr2");

const btn_order_modal = document.querySelector("#btn_order_modal");
// 장바구니에 주문상품 없을 시 주문하기 버튼 비활성화
if (idx.length == 0) {
    btn_order_modal.classList.add("disabled");
}
btn_order_modal.addEventListener("click", () => {

    const m_name = document.querySelector("#m_name");
    const m_email = document.querySelector("#m_email");
    const m_zipcode = document.querySelector("#m_zipcode");
    const m_addr1 = document.querySelector("#m_addr1");
    const m_addr2 = document.querySelector("#m_addr2");

    if (m_id) {
        modal_m_name.value = m_name.value;
        modal_m_email.value = m_email.value;
        modal_m_zipcode.value = m_zipcode.value;
        modal_m_addr1.value = m_addr1.value;
        modal_m_addr2.value = m_addr2.value;
    }
});

// 주문 하기 버튼 클릭 시 이벤트 발생
const btn_order = document.querySelector("#btn_order");
btn_order.addEventListener("click", () => {
    if (modal_m_name.value == "" || modal_m_email.value == "" || modal_m_phone.value == "" || modal_m_zipcode.value == "" || modal_m_addr1.value == "" || modal_m_addr2.value == "") {
        alert("빈 값 없이 채워주시기 바랍니다.");
        return;
    }

    const total_price = document.querySelector("#total_price");

    IMP.init("imp88703567");
    IMP.request_pay({
        pg : 'kakaopay', 
        pay_method : 'card',
        merchant_uid : 'merchant_' + new Date().getTime(), // 주문 번호
        name : "장바구니 물품 구매", // 상품 이름
        amount : total_price.textContent,  // 상품 가격
        buyer_email : modal_m_email.value, // 구매자 이메일
        buyer_name : modal_m_name.value, // 구매자 이름
        buyer_tel : modal_m_phone.value, // 구매자 휴대폰 번호
        buyer_addr : modal_m_addr1.value + " " + modal_m_addr2.value, // 구매자 주소
        buyer_postcode : modal_m_zipcode.value // 구매자 우편 번호
    }, function(res) {
        console.log(res);
        if (res.success) {
            const f1 = new FormData();
            f1.append("order_uid", res.merchant_uid);
            f1.append("m_id", m_id.value);
            f1.append("m_name", res.buyer_name);
            f1.append("m_phone", res.buyer_tel);
            f1.append("m_email", res.buyer_email);
            f1.append("m_zipcode", res.buyer_postcode);
            f1.append("m_addr", res.buyer_addr);
            f1.append("p_total_price", res.paid_amount);
            f1.append("mode", "order");
            f1.append("length", idx.length);
            
            for (let i = 0; i < idx.length; i++) {
                f1.append("p_name" + i, pname[i].textContent);
                f1.append("p_code" + i, p_code[i].value);
                f1.append("p_cnt" + i, cnt[i].textContent);
                f1.append("p_one_price" + i, price[i].textContent);
            }
            

            const xhr = new XMLHttpRequest();
            xhr.open("POST", "./process/cart_process.php", true);
            xhr.send(f1);
            xhr.onload = () => {
                if (xhr.status == 200) {
                    const data = JSON.parse(xhr.response);

                    if (data.result == "success") {
                        alert("해당 상품 주문 완료되었습니다.");
                        self.location.reload();
                    }
                } else {
                    alert("통신 실패 " + xhr.status);
                }
            }

            
        } else {
            const msg = '결제에 실패하였습니다.';
            msg += '에러내용 : ' + res.error_msg;
        }
    });
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

            modal_m_addr1.value = addr + extra_arr;
            modal_m_zipcode.value = data.zonecode;
            modal_m_addr2.focus();

        }
    }).open();
});
