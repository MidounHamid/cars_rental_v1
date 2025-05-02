document.addEventListener('DOMContentLoaded', function() {
    // Image gallery functionality
    const mainImage = document.getElementById('main-image');
    const thumbnails = document.querySelectorAll('.thumbnail');

    thumbnails.forEach(thumb => {
        thumb.addEventListener('click', function() {
            // Change main image
            mainImage.src = this.getAttribute('data-src');

            // Update active state
            thumbnails.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
        });
    });

    // Initialize Flatpickr for date inputs
    const dateConfig = {
        enableTime: false,
        dateFormat: "Y-m-d",
        minDate: "today",
        altInput: true,
        altFormat: "F j, Y",
        monthSelectorType: "static",
        locale: {
            firstDayOfWeek: 1
        }
    };

    const timeConfig = {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true,
        minuteIncrement: 30
    };

    // Initialize date pickers
    flatpickr(".pickup-date", dateConfig);
    flatpickr(".return-date", {
        ...dateConfig,
        minDate: document.querySelector('.pickup-date').value || "today"
    });

    // Initialize time pickers
    flatpickr(".pickup-time", timeConfig);
    flatpickr(".return-time", timeConfig);

    // Update return date min value when pickup date changes
    document.querySelector('.pickup-date').addEventListener('change', function(e) {
        const returnDatePicker = document.querySelector('.return-date')._flatpickr;
        returnDatePicker.set('minDate', e.target.value || "today");
    });

    // Accordion functionality
    const accordionHeaders = document.querySelectorAll('.accordion-header');

    accordionHeaders.forEach(header => {
        header.addEventListener('click', function() {
            const accordionItem = this.parentElement;
            const content = this.nextElementSibling;
            const icon = this.querySelector('.accordion-icon');

            // Toggle content visibility
            if (content.style.display === 'block') {
                content.style.display = 'none';
                icon.textContent = '▼';
            } else {
                content.style.display = 'block';
                icon.textContent = '▲';
            }
        });
    });
});
