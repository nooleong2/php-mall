'use strict';

// 카테고리 

// 국가 코드 바뀔 시
const county_kr = document.querySelector("#country_kr");
fetch("https://api.odcloud.kr/api/15091117/v1/uddi:bbcc2939-88e0-4a54-af03-ab819b4130e6?page=1&perPage=196&serviceKey=9YXu96O7L55pOKormzV9dkWRjCclJBxN%2FojxDt5%2FPm4HefpZiwjqG6PLhPVaiXJx5VgI7K0JSF3EGiwRl6W%2Fhg%3D%3D")
.then(
    (response) => response.json()
).then(
    (data) => {
        for (let i = 0; i < data.totalCount; i++) {
            const selectOption = document.createElement("option");
            selectOption.setAttribute("value", data.data[i]["ISO alpha3"]);
            selectOption.innerHTML = data.data[i]["한글명"];
            county_kr.appendChild(selectOption);
        }

        county_kr.addEventListener("change", (e) => {
            e.preventDefault();

            const county_en = document.querySelector("#country_en");
            if (e.target.value == "") {
                county_en.value = "KOR";
            } else {
                county_en.value = e.target.value;
            }
            
        });
    }
);






