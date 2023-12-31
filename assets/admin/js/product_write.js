'use strict';

// 국가 코드 바뀔 시
const county_kr = document.querySelector("#country_kr");
fetch("https://api.odcloud.kr/api/15091117/v1/uddi:bbcc2939-88e0-4a54-af03-ab819b4130e6?page=1&perPage=196&serviceKey=9YXu96O7L55pOKormzV9dkWRjCclJBxN%2FojxDt5%2FPm4HefpZiwjqG6PLhPVaiXJx5VgI7K0JSF3EGiwRl6W%2Fhg%3D%3D")
.then(
    (response) => response.json()
).then(
    (data) => {

        const korOption = document.createElement("option");
        korOption.setAttribute("value", "KOR");
        korOption.innerHTML = "대한민국";
        county_kr.appendChild(korOption);

        for (let i = 0; i < data.totalCount; i++) {
            // ISO alpha3 (영문 3자리), 한글명
            const selectOption = document.createElement("option");
            selectOption.setAttribute("value", data.data[i]["ISO alpha3"]);
            selectOption.innerHTML = data.data[i]["한글명"];
            county_kr.appendChild(selectOption);
        }

        county_kr.addEventListener("change", (e) => {
            e.preventDefault();
            
            const county_en = document.querySelector("#country_en");
            county_en.value = e.target.value;
            
        });
    }
);

// 이미지 파일 변동이 생길 시
const photo = document.querySelector("#photo");
photo.addEventListener("change", (e) => {

    // 파일 리더 객체를 통해 event에 들어와있는 file을 읽음
    const reader = new FileReader();
    reader.readAsDataURL(e.target.files[0]);
    reader.onload = (e) => {
        const preview = document.querySelector("#preview");
        preview.setAttribute("src", e.target.result);
    }
});

// 등록 버튼 클릭
const btn_submit = document.querySelector("#btn_submit");
btn_submit.addEventListener("click", () => {
    const ccode = document.querySelector("#ccode");
    const pcode = document.querySelector("#pcode");
    const country_kr = document.querySelector("#country_kr");
    const country_en = document.querySelector("#country_en");
    const price = document.querySelector("#price");
    const cnt = document.querySelector("#cnt");
    const name = document.querySelector("#name");
    const bio = document.querySelector("#bio");
    const photo =document.querySelector("#photo");

    const f1 = new FormData();
    f1.append("ccode", ccode.value);
    f1.append("pcode", pcode.value);
    f1.append("country_kr", country_kr.options[country_kr.selectedIndex].text); // option에 선택 된 텍스트 값 가져오는 방법
    f1.append("country_en", country_en.value);
    f1.append("price", price.value);
    f1.append("cnt", cnt.value);
    f1.append("name", name.value);
    f1.append("bio", bio.value);
    f1.append("photo", photo.files[0]);
    f1.append("mode", "add");

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "./process/product_process.php", true);
    xhr.send(f1);
    xhr.onload = () => {
        if (xhr.status == 200) {
            const data = JSON.parse(xhr.response);

            if (data.result == "empty_mode") {
                alert("모드가 존재하지 않습니다.");
            } else if (data.result == "empty_pcode") {
                alert("상품 코드가 존재하지 않습니다.");
                pcode.focus();
            } else if (data.result == "empty_ccode") {
                alert("카테고리 코드가 존재하지 않습니다.");
                ccode.focus();
            } else if (data.result == "empty_country_kr") {
                alert("국가코드(한) 존재하지 않습니다.");
                country_kr.focus();
            } else if (data.result == "empty_country_en") {
                alert("국가코드(영) 존재하지 않습니다.");
                country_en.focus();
            } else if (data.result == "empty_price") {
                alert("가격이 존재하지 않습니다.");
                price.focus();
            } else if (data.result == "empty_cnt") {
                alert("상품 수 존재하지 않습니다.");
                cnt.focus();
            } else if (data.result == "empty_name") {
                alert("상품명이 존재하지 않습니다.");
                name.focus();
            } else if (data.result == "empty_photo") {
                alert("상품 이미지가 존재하지 않습니다.");
                photo.focus();
            } else if (data.result == "already_pcode") {
                alert("상품 코드가 이미 존재합니다.");
                pcode.focus();
            } else if (data.result == "wrong_type") {
                alert("지원하지 않는 이미지 확장자입니다.");
                pcode.focus();
            } else if (data.result == "over_string") {
                alert("상품 코드의 길이가 초과하였습니다.");
                pcode.focus();
            } else if (data.result == "success_add") {
                alert("상품 등록 되었습니다.");
                self.location.href = "./product.php";
            }
        } else {
            alert("통신 실패 " + xhr.status);
        }
    }
});