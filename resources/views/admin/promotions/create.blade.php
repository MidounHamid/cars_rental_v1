@extends('admin.layouts.app')

@section('content')
<div class="table-container">
    <h2>Add New Promotion</h2>
    <form action="{{ route('promotions.store') }}" method="POST" class="promotion-form">
        @csrf

        <div class="form-row">
            <div class="form-group">
                <label for="discount_percent">Discount Percent</label>
                <input type="number" id="discount_percent" name="discount_percent" class="form-input" value="{{ old('discount_percent') }}" step="0.01" min="0" max="100">
                @error('discount_percent')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="starts_at">Start Date</label>
                <input type="date" id="starts_at" name="starts_at" class="form-input" value="{{ old('starts_at') }}">
                @error('starts_at')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="expires_at">Expiry Date</label>
                <input type="date" id="expires_at" name="expires_at" class="form-input" value="{{ old('expires_at') }}">
                @error('expires_at')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-footer">
            <button type="submit" class="add-btn">Create Promotion</button>
            <a href="{{ route('promotions.index') }}" class="cancel-btn">Cancel</a>
        </div>
    </form>
</div>
@endsection
