document.addEventListener("DOMContentLoaded", function () {
    // Image carousel functionality
    const mainImage = document.getElementById("main-image");
    const thumbnails = document.querySelectorAll(".thumbnail");
    let currentImageIndex = 0;

    thumbnails.forEach((thumb, index) => {
        thumb.addEventListener("click", () => {
            mainImage.src = thumb.dataset.src;
            thumbnails.forEach((t) => t.classList.remove("active"));
            thumb.classList.add("active");
            currentImageIndex = index;
        });
    });

    // Swipe functionality for main image
    let touchStartX = 0;
    let touchEndX = 0;

    mainImage.addEventListener("touchstart", (e) => {
        touchStartX = e.changedTouches[0].screenX;
    });

    mainImage.addEventListener("touchend", (e) => {
        touchEndX = e.changedTouches[0].screenX;
        handleSwipe();
    });

    function handleSwipe() {
        const swipeThreshold = 50;
        const diff = touchEndX - touchStartX;

        if (Math.abs(diff) < swipeThreshold) return;

        if (diff > 0 && currentImageIndex > 0) {
            // Swipe right
            currentImageIndex--;
        } else if (diff < 0 && currentImageIndex < thumbnails.length - 1) {
            // Swipe left
            currentImageIndex++;
        }

        thumbnails[currentImageIndex].click();
    }

    // Accordion functionality
    document.querySelectorAll(".accordion-header").forEach((header) => {
        header.addEventListener("click", () => {
            const item = header.parentElement;
            item.classList.toggle("collapsed");
        });
    });
});
