document.addEventListener("DOMContentLoaded", function () {
  // Xử lý tìm kiếm xe
  const form = document.getElementById("searchForm");
  const input = document.getElementById("searchInput");
  const carItems = document.querySelectorAll(".car-item");

  if (form && input && carItems) {
    form.addEventListener("submit", function (e) {
      e.preventDefault();
      const keyword = input.value.trim().toLowerCase();
      carItems.forEach((item) => {
        const name = item.getAttribute("data-name").toLowerCase();
        if (name.includes(keyword)) {
          item.style.display = "block";
        } else {
          item.style.display = "none";
        }
      });
    });
  }

  // Xử lý hiển thị chi tiết xe khi click
  const modal = document.getElementById("carModal");
  const modalImg = document.getElementById("modalImg");
  const modalName = document.getElementById("modalName");
  const modalDesc = document.getElementById("modalDesc");
  const modalPrice = document.getElementById("modalPrice");
  const closeBtn = document.querySelector(".modal .close");

  if (modal && modalImg && modalName && modalDesc && modalPrice) {
    document.querySelectorAll(".car-item button").forEach((button) => {
      button.addEventListener("click", function (e) {
        e.stopPropagation(); // Ngăn click lan ra ngoài
        const item = this.closest(".car-item");
        modal.style.display = "flex";
        modalImg.src = item.dataset.img;
        modalName.textContent = item.dataset.name;
        modalDesc.innerHTML = item.dataset.desc;
        modalPrice.textContent = "Giá thuê: " + item.dataset.price;
      });
    });

    // Đóng popup khi bấm X
    if (closeBtn) {
      closeBtn.addEventListener("click", function () {
        modal.style.display = "none";
      });
    }
    // Đóng popup khi bấm ra ngoài modal-content
    window.addEventListener("click", function (event) {
      if (event.target === modal) {
        modal.style.display = "none";
      }
    });
    // Đóng popup khi bấm phím ESC
    window.addEventListener("keydown", function (e) {
      if (e.key === "Escape") {
        modal.style.display = "none";
      }
    });
  } else {
    console.error("Không tìm thấy popup/modal hoặc các thành phần bên trong.");
  }
});