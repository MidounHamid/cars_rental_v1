<div id="car-rental-calculator">
    <!-- Pickup Form Section -->
    <div class="form-section">
        <label class="form-label">PICKUP DATE & TIME</label>
        <div class="form-control-wrapper">
            <svg class="form-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                <line x1="16" y1="2" x2="16" y2="6"></line>
                <line x1="8" y1="2" x2="8" y2="6"></line>
                <line x1="3" y1="10" x2="21" y2="10"></line>
            </svg>
            <input type="text" id="pickup-date" class="form-control pickup-date" wire:model.live="pickup_date"
                placeholder="Pickup Date">
        </div>
        <div class="form-control-wrapper">
            <svg class="form-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"></circle>
                <polyline points="12 6 12 12 16 14"></polyline>
            </svg>
            <input type="text" id="pickup-time" class="form-control pickup-time" wire:model.live="pickup_time"
                placeholder="Pickup Time">
        </div>
    </div>

    <!-- Return Form Section -->
    <div class="form-section">
        <label class="form-label">RETURN DATE & TIME</label>
        <div class="form-control-wrapper">
            <svg class="form-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                <line x1="16" y1="2" x2="16" y2="6"></line>
                <line x1="8" y1="2" x2="8" y2="6"></line>
                <line x1="3" y1="10" x2="21" y2="10"></line>
            </svg>
            <input type="text" id="return-date" class="form-control return-date" wire:model.live="return_date"
                placeholder="Return Date">
        </div>
        <div class="form-control-wrapper">
            <svg class="form-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"></circle>
                <polyline points="12 6 12 12 16 14"></polyline>
            </svg>
            <input type="text" id="return-time" class="form-control return-time" wire:model.live="return_time"
                placeholder="Return Time">
        </div>
    </div>

    <!-- Specifications Table -->
    <div class="specifications-section">
        <h3 class="section-title">
            <svg class="section-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2">
                <path
                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
            SPECIFICATIONS TABLE
        </h3>
        <div class="specifications-table">
            @foreach ($specifications as $spec)
                <div class="spec-row" id="spec-{{ $spec->id }}">
                    <div class="spec-name">
                        {{-- <span class="spec-circle"
                            style="display: inline-block; width: 12px; height: 12px; background-color: #3c82f6; border-radius: 50%; margin-right: 8px;"></span> --}}
                        {{ $spec->name }}
                    </div>
                    <div class="spec-quantity">
                        <button type="button" class="quantity-btn minus"
                            wire:click="decreaseSpecQuantity({{ $spec->id }})">-</button>
                        <span class="quantity-value" id="spec-{{ $spec->id }}-quantity"
                            data-price="{{ $spec->price }}">
                            {{ $selected_specifications[$spec->id] ?? 0 }}
                        </span>
                        <button type="button" class="quantity-btn plus"
                            wire:click="increaseSpecQuantity({{ $spec->id }})">+</button>
                        <button type="button" class="reset-btn" wire:click="resetSpecQuantity({{ $spec->id }})">
                            <svg class="reset-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="18" y1="6" x2="6" y2="18" />
                                <line x1="6" y1="6" x2="18" y2="18" />
                            </svg>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Pricing Info -->
    <div class="pricing-info">
        <h3 class="section-title">
            <svg class="section-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2">
                <line x1="12" y1="1" x2="12" y2="23" />
                <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
            </svg>
            PRICING INFO
        </h3>
        <div class="price-details">
            <div class="price-row">
                <span>Base Rate (per day)</span>
                <span class="base-rate" id="base-rate">{{ number_format($base_price, 2) }} MAD</span>
            </div>
            <div class="price-row">
                <span>Rental Duration</span>
                <span class="rental-duration" id="rental-duration">{{ $rental_duration }} days</span>
            </div>
            <div class="price-row">
                <span>Additional Options</span>
                <span class="additional-options" id="additional-options">{{ number_format($additional_options, 2) }}
                    MAD</span>
            </div>
            <div class="price-row total">
                <span>Total Price</span>
                <span class="total-price" id="total-price">{{ number_format($total_price, 2) }} MAD</span>
            </div>
        </div>
    </div>

    <!-- Book Now Button -->
    <button type="button" wire:click="bookNow" class="btn-book">Book Now</button>


    @push('scripts')
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
        <script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
        <style>
            .daterangepicker {
                border: none;
                border-radius: 8px;
                box-shadow: 0 4px 15px rgba(0,0,0,0.1);
                font-family: inherit;
            }
            .daterangepicker .calendar-table {
                border: none;
                background: white;
            }
            .daterangepicker td.active {
                background-color: #080808 !important;
                color: white !important;
            }
            .daterangepicker td.in-range {
                background-color: #e2e8f0;
                color: #2d3748;
            }
            .daterangepicker td.available:hover {
                background-color: #f7fafc;
            }
            .daterangepicker .calendar-table th,
            .daterangepicker .calendar-table td {
                width: 36px;
                height: 36px;
            }
            .daterangepicker .drp-buttons {
                border-top: 1px solid #e2e8f0;
                padding: 1rem;
            }
            .daterangepicker .drp-selected {
                font-size: 14px;
                color: #4a5568;
            }
            .daterangepicker .applyBtn,
            .daterangepicker .cancelBtn {
                padding: 8px 16px;
                border-radius: 4px;
                font-size: 14px;
            }
            .daterangepicker .applyBtn {
                background-color: #080808;
                border-color: transparent;
                color: #fff;
            }
            .daterangepicker .cancelBtn {
                color: #4a5568;
                border-color: #e2e8f0;
                background: white;
            }
        </style>
        <script>
            document.addEventListener('livewire:initialized', function() {
                // Initialize DateRangePicker for pickup and return date
                function initDatePickers() {
                    if ($('#pickup-date').data('daterangepicker')) {
                        $('#pickup-date').data('daterangepicker').remove();
                    }
                    if ($('#return-date').data('daterangepicker')) {
                        $('#return-date').data('daterangepicker').remove();
                    }
                    $('#pickup-date').daterangepicker({
                        singleDatePicker: true,
                        showDropdowns: true,
                        minDate: moment(),
                        locale: {
                            format: 'YYYY-MM-DD',
                            firstDay: 1
                        }
                    }, function(start) {
                        @this.set('pickup_date', start.format('YYYY-MM-DD'));
                    });
                    $('#return-date').daterangepicker({
                        singleDatePicker: true,
                        showDropdowns: true,
                        minDate: moment(),
                        locale: {
                            format: 'YYYY-MM-DD',
                            firstDay: 1
                        }
                    }, function(start) {
                        @this.set('return_date', start.format('YYYY-MM-DD'));
                    });
                }
                initDatePickers();
                Livewire.hook('morph.updated', () => {
                    initDatePickers();
                });
            });
        </script>
    @endpush
</div>
