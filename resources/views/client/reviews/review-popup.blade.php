@push('styles')
    <style>
        .review-popup {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .review-popup.active {
            display: flex;
        }

        .review-popup-content {
            background-color: white;
            padding: 2.5rem;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            width: 90%;
            max-width: 500px;
            position: relative;
            border-top: 5px solid #DC1E2D;
        }

        .review-popup h2 {
            text-align: center;
            color: #DC1E2D;
            margin-bottom: 1.5rem;
            font-size: 1.75rem;
            font-weight: 600;
        }

        .star-rating {
            display: flex;
            flex-direction: row-reverse;
            justify-content: center;
            gap: 0.75rem;
            margin-bottom: 1rem;
        }

        .star-rating input {
            display: none;
        }

        .star-rating label {
            font-size: 2.75rem;
            color: #e5e5e5;
            cursor: pointer;
            transition: color 0.2s ease-in-out, transform 0.1s ease;
        }

        .star-rating label:hover {
            transform: scale(1.1);
        }

        .star-rating label:hover,
        .star-rating label:hover~label,
        .star-rating input:checked~label {
            color: #ffc107;
        }

        .review-textarea {
            margin-bottom: 1rem;
        }

        .review-textarea textarea {
            width: 100%;
            min-height: 120px;
            padding: 1rem;
            border: 1px solid #e5e5e5;
            border-radius: 8px;
            resize: vertical;
            font-family: inherit;
            font-size: 1rem;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .review-textarea textarea:focus {
            outline: none;
            border-color: #DC1E2D;
            box-shadow: 0 0 0 3px rgba(220, 30, 45, 0.2);
        }

        .review-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-top: 2rem;
        }

        .review-buttons button {
            padding: 0.875rem 2rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.2s ease-in-out;
        }

        .submit-review {
            background-color: #DC1E2D;
            color: white;
            flex-grow: 2;
            max-width: 70%;
            box-shadow: 0 4px 6px rgba(220, 30, 45, 0.2);
        }

        .submit-review:hover {
            background-color: #b91824;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(220, 30, 45, 0.25);
        }

        .submit-review:active {
            transform: translateY(0);
        }

        .cancel-review {
            background-color: #f9fafb;
            color: #6b7280;
            border: 1px solid #e5e5e5;
            flex-grow: 1;
        }

        .cancel-review:hover {
            background-color: #f3f4f6;
            color: #4b5563;
        }

        .error-message {
            color: #ef4444;
            font-size: 0.875rem;
            margin-bottom: 1rem;
            min-height: 1.25rem;
            text-align: center;
        }

        .success-message {
            position: fixed;
            top: 1.5rem;
            right: 1.5rem;
            background-color: #DC1E2D;
            color: white;
            padding: 1rem 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            z-index: 1100;
            display: none;
            font-weight: 500;
            animation: slideIn 0.3s ease-out;
        }

        @keyframes slideIn {
            0% {
                transform: translateX(100%);
                opacity: 0;
            }

            100% {
                transform: translateX(0);
                opacity: 1;
            }
        }

        /* Add a subtle background pattern */
        .review-popup-content::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 100px;
            background-color: rgba(220, 30, 45, 0.05);
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
            z-index: -1;
        }
    </style>
@endpush

<!-- Review Popup -->
<div class="review-popup" id="reviewPopup">
    <div class="review-popup-content">
        <h2>Rate Your Experience</h2>
        <form id="reviewForm">
            @csrf
            <input type="hidden" name="car_id" id="carId">

            <div class="star-rating">
                <input type="radio" id="star5" name="rating" value="5">
                <label for="star5">★</label>
                <input type="radio" id="star4" name="rating" value="4">
                <label for="star4">★</label>
                <input type="radio" id="star3" name="rating" value="3">
                <label for="star3">★</label>
                <input type="radio" id="star2" name="rating" value="2">
                <label for="star2">★</label>
                <input type="radio" id="star1" name="rating" value="1">
                <label for="star1">★</label>
            </div>
            <div class="error-message" id="ratingError"></div>

            <div class="review-textarea">
                <textarea name="comment" id="comment" placeholder="Share your experience with us..."></textarea>
            </div>
            <div class="error-message" id="commentError"></div>

            <div class="review-buttons">
                <button type="submit" class="submit-review">Submit Review</button>
                <button type="button" class="cancel-review" onclick="closeReviewPopup()">Cancel</button>
            </div>
        </form>
    </div>
</div>

<div id="successMessage" class="success-message"></div>

@push('scripts')
    <script>
        $(document).ready(function() {
            // Only initialize review functionality if we're on the correct page
            if ($('#reviewPopup').length === 0) return;

            const form = $('#reviewForm');
            const successMessage = $('#successMessage');
            let isSubmitting = false;

            function showSuccess(message) {
                successMessage.text(message).fadeIn();
                setTimeout(() => {
                    successMessage.fadeOut(300);
                }, 3000);
            }

            function showError(message) {
                const errorDiv = $('<div>').addClass('error-message').text(message);
                form.prepend(errorDiv);
                setTimeout(() => {
                    errorDiv.fadeOut(300, function() {
                        $(this).remove();
                    });
                }, 3000);
            }

            function clearErrors() {
                $('.error-message').text('');
            }

            form.on('submit', function(e) {
                e.preventDefault();

                // Prevent double submission
                if (isSubmitting) return;
                isSubmitting = true;

                clearErrors();

                // Get the form data
                const rating = $('input[name="rating"]:checked').val();
                const comment = $('#comment').val();
                const carId = $('#carId').val();

                // Validate required fields
                if (!rating) {
                    $('#ratingError').text('Please select a rating');
                    isSubmitting = false;
                    return;
                }

                // Create form data
                const formData = new FormData();
                formData.append('_token', '{{ csrf_token() }}');
                formData.append('rating', rating);
                formData.append('car_id', carId);
                if (comment && comment.trim()) {
                    formData.append('comment', comment.trim());
                }

                // Disable form elements during submission
                const submitButton = form.find('button[type="submit"]');
                const originalButtonText = submitButton.text();
                submitButton.prop('disabled', true).text('Submitting...');

                $.ajax({
                        url: '{{ route('reviews.store') }}',
                        method: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    })
                    .done(function(response) {
                        if (response.success) {
                            showSuccess(response.message);
                            closeReviewPopup();
                            setTimeout(() => {
                                location.reload();
                            }, 1500);
                        } else {
                            showError(response.message || 'An error occurred while saving the review.');
                        }
                    })
                    .fail(function(xhr) {
                        console.error('Review submission error:', xhr);
                        if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                            const errors = xhr.responseJSON.errors;
                            Object.keys(errors).forEach(key => {
                                $(`#${key}Error`).text(errors[key][0]);
                            });
                        } else {
                            showError('An error occurred. Please try again.');
                        }
                    })
                    .always(function() {
                        isSubmitting = false;
                        submitButton.prop('disabled', false).text(originalButtonText);
                    });
            });
        });

        function openReviewPopup(carId) {
            if (!carId) {
                console.error('No car ID provided');
                return;
            }

            // Clear any existing data
            clearErrors();
            $('#reviewForm')[0].reset();

            // Set new data
            $('#carId').val(carId);

            // Show popup
            $('#reviewPopup').addClass('active');
        }

        function closeReviewPopup() {
            $('#reviewPopup').removeClass('active');
            $('#reviewForm')[0].reset();
            clearErrors();
        }

        function clearErrors() {
            $('.error-message').text('');
        }

        // Close popup when clicking outside
        $(document).mouseup(function(e) {
            const popup = $('#reviewPopup .review-popup-content');
            if (popup.length && !popup.is(e.target) && popup.has(e.target).length === 0) {
                closeReviewPopup();
            }
        });
    </script>
@endpush
