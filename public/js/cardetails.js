document.addEventListener('DOMContentLoaded', function() {
    // Image carousel functionality
    const mainImage = document.getElementById('main-image');
    const thumbnails = document.querySelectorAll('.thumbnail');
    let currentImageIndex = 0;

    thumbnails.forEach((thumb, index) => {
        thumb.addEventListener('click', () => {
            mainImage.src = thumb.dataset.src;
            thumbnails.forEach(t => t.classList.remove('active'));
            thumb.classList.add('active');
            currentImageIndex = index;
        });
    });

    // Swipe functionality for main image
    let touchStartX = 0;
    let touchEndX = 0;

    mainImage.addEventListener('touchstart', e => {
        touchStartX = e.changedTouches[0].screenX;
    });

    mainImage.addEventListener('touchend', e => {
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

    // Specifications and pricing functionality
    const quantityBtns = document.querySelectorAll('.quantity-btn');
    const resetBtns = document.querySelectorAll('.reset-btn');
    const baseRate = parseFloat(document.querySelector('.base-rate').textContent.replace(/[^0-9.]/g, ''));
    const pickupDate = document.querySelector('.pickup-date');
    const returnDate = document.querySelector('.return-date');

    function updateTotalPrice() {
        let additionalOptions = 0;
        document.querySelectorAll('.quantity-value').forEach(value => {
            const quantity = parseInt(value.textContent);
            const price = parseFloat(value.dataset.price);
            additionalOptions += quantity * price;
        });

        let days = 1;
        if (pickupDate.value && returnDate.value) {
            const start = new Date(pickupDate.value);
            const end = new Date(returnDate.value);
            days = Math.max(1, Math.ceil((end - start) / (1000 * 60 * 60 * 24)));
        }

        document.querySelector('.rental-duration').textContent = `${days} days`;
        document.querySelector('.additional-options').textContent = `${additionalOptions.toFixed(2)} MAD`;
        const total = (baseRate * days) + additionalOptions;
        document.querySelector('.total-price').textContent = `${total.toFixed(2)} MAD`;
    }

    quantityBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const quantitySpan = btn.parentElement.querySelector('.quantity-value');
            let quantity = parseInt(quantitySpan.textContent);
            
            if (btn.classList.contains('plus')) {
                quantity++;
            } else if (btn.classList.contains('minus') && quantity > 0) {
                quantity--;
            }
            
            quantitySpan.textContent = quantity;
            updateTotalPrice();
        });
    });

    resetBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const quantitySpan = btn.parentElement.querySelector('.quantity-value');
            quantitySpan.textContent = '0';
            updateTotalPrice();
        });
    });

    // Date change handlers
    pickupDate.addEventListener('change', updateTotalPrice);
    returnDate.addEventListener('change', updateTotalPrice);

    // Accordion functionality
    document.querySelectorAll('.accordion-header').forEach(header => {
        header.addEventListener('click', () => {
            const item = header.parentElement;
            item.classList.toggle('collapsed');
        });
    });

    // Initial price calculation
    updateTotalPrice();
});
