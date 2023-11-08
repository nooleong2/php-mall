'use strict';

const btn_order_excel = document.querySelector("#btn_order_excel");
btn_order_excel.addEventListener("click", () => {
    self.location.href = "./process/excel_process.php";
});