'use strict';

const btn_logout = document.querySelector("#btn_logout");
btn_logout.addEventListener("click", () => {
    self.location.href = "./process/logout_process.php";
});