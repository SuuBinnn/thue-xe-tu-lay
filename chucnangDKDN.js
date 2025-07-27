//đăng nhập
document.addEventListener("DOMContentLoaded", function () {
  // Tìm tất cả các button có text "Thuê ngay"
  var buttons = Array.from(document.querySelectorAll("button")).filter(
    (btn) => btn.textContent.trim().toLowerCase() === "thuê ngay"
  );
  buttons.forEach(function (btn) {
    btn.addEventListener("click", function (e) {
      e.preventDefault();
      window.location.href = "http://localhost:8080/xulydangky/dangnhap.html";
    });
  });
});
