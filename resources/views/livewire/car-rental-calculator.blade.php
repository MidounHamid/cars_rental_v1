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
    <div class="specifications-section styled-box">
        <label class="form-label">SPECIFICATIONS</label>
        <div class="spec-table-header">
            <span>Option</span>
            <span>Quantity</span>
        </div>
        <div class="specifications-table">
            @foreach ($specifications as $spec)
                <div class="spec-row" id="spec-{{ $spec->id }}">
                    <div class="spec-name">
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
    <div class="price-info">
        <h3>Pricing Info</h3>
        <div class="price-line">
            <span>Base Rate (per day)</span>
            <span>{{ number_format($base_price, 2) }} MAD</span>
        </div>
        <div class="price-line">
            <span>Rental Duration</span>
            <span id="rental-days">{{ $rental_duration }} days</span>
        </div>
        <div class="price-line">
            <span>Additional Options</span>
            <span id="features-price">{{ number_format($additional_options, 2) }} MAD</span>
        </div>
        <div class="price-line">
            <span>Total Price</span>
            <span id="total-price">{{ number_format($total_price, 2) }} MAD</span>
        </div>
    </div>

    <!-- Book Now Button -->
    <button type="button" wire:click="bookNow" class="btn-book">Book Now</button>


    @push('scripts')
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
        <script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
        <style>
            :root {
                --light-color: #f8f9fa;
                --border-radius: 5px;
            }
            .price-info {
                background-color: var(--light-color);
                padding: 20px;
                border-radius: var(--border-radius);
                margin-top: 20px;
            }
            .price-info h3 {
                margin-bottom: 15px;
                font-size: 16px;
                text-transform: uppercase;
                letter-spacing: 1px;
            }
            .price-line {
                display: flex;
                justify-content: space-between;
                padding: 10px 0;
                border-bottom: 1px solid #ddd;
            }
            .price-line:last-child {
                border-bottom: none;
                font-weight: bold;
            }
            /* DateRangePicker: remplacer le bleu par le noir, sans border-color */
            .daterangepicker td.active, .daterangepicker td.active:hover {
                background-color: #080808 !important;
                border-color: transparent !important;
                color: #fff !important;
            }
            .daterangepicker .applyBtn {
                background-color: #080808 !important;
                border-color: #080808 !important;
                color: #fff !important;
            }
            .daterangepicker .applyBtn:hover {
                background-color: #222 !important;
                border-color: #222 !important;
            }
            
            .styled-box {
                background: #fafbfc;
              
                border-radius: 7px;
                padding: 0 0 18px 0;
                margin-bottom: 22px;
                box-shadow: none;
            }
            .spec-table-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                background: #f5f6f7;
                border-bottom: 1px solid #e2e8f0;
                border-radius: 7px 7px 0 0;
                font-size: 15px;
                font-weight: 600;
                color: #444;
                padding: 12px 18px 12px 18px;
                text-transform: capitalize;
            }
            .specifications-table {
                padding: 0 18px;
            }
            .spec-row {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 16px 0;
                border-bottom: 1px solid #eee;
            }
            .spec-row:last-child {
                border-bottom: none;
            }
            .spec-name {
                font-size: 15px;
                color: #222;
            }
            .spec-quantity {
                display: flex;
                align-items: center;
            }
            .quantity-btn, .reset-btn {
                margin: 0 2px;
            }
        </style>
        <script>
        $(function() {
            $('#pickup-date').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                minDate: moment(),
                locale: {
                    format: 'YYYY-MM-DD',
                    firstDay: 1
                }
            });
            $('#return-date').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                minDate: moment(),
                locale: {
                    format: 'YYYY-MM-DD',
                    firstDay: 1
                }
            });
        });
        </script>
    @endpush
</div>
