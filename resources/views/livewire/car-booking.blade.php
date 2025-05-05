<div>
    <div class="form-section">
        <label class="form-label">Pickup Date</label>
        <input type="date" wire:model.lazy="pickup_date" class="form-control">
    </div>

    <div class="form-section">
        <label class="form-label">Return Date</label>
        <input type="date" wire:model.lazy="return_date" class="form-control">
    </div>

    <div class="form-section">
        <label class="form-label">Total Price</label>
        <input type="text" class="form-control" value="{{ number_format($total_price, 2) }}" readonly>
    </div>
</div>
