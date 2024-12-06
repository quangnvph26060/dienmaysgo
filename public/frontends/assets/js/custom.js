document.querySelector(".cart-link").addEventListener("click", function (e) {
    e.preventDefault();
    const popup = document.querySelector(".mfp-content");

    // Hiển thị popup với animation

    setTimeout(() => {
        popup.classList.add("open");
        document.querySelector(".off-canvas#cart-popup").style.display = "block"; // Đảm bảo nó hiện trước

        document.querySelector(".mfp-bg").style.display = "block";
    }, 300); // Thêm một chút thời gian để áp dụng hiệu ứng trượt
});

// Tùy chọn: Đóng popup
document.querySelector(".mfp-bg").addEventListener("click", function () {
    const popup = document.querySelector(".mfp-content");

    console.log(popup);

    popup.classList.remove("open");
    setTimeout(() => {
        document.querySelector(".off-canvas#cart-popup").style.display = "none"; // Ẩn sau khi hiệu ứng hoàn tất
        document.querySelector(".mfp-bg").style.display = "none";
    }, 300);
});
