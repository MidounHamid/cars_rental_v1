@extends('admin.layouts.app')

@section('content')
<div class="table-container">
    <h2>Edit Promotion</h2>
    <form action="{{ route('promotions.update', $promotion->id) }}" method="POST" class="promotion-form">
        @csrf
        @method('PUT')

        <div class="form-row">
            <div class="form-group">
                <label for="discount_percent">Discount Percent</label>
                <input type="number" id="discount_percent" name="discount_percent" class="form-input" value="{{ old('discount_percent', $promotion->discount_percent) }}" step="0.01" min="0" max="100">
                @error('discount_percent')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="starts_at">Start Date</label>
                <input type="date" id="starts_at" name="starts_at" class="form-input" value="{{ old('starts_at', \Carbon\Carbon::parse($promotion->starts_at)->format('Y-m-d')) }}">
                @error('starts_at')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="expires_at">Expiry Date</label>
                <input type="date" id="expires_at" name="expires_at" class="form-input" value="{{ old('expires_at', \Carbon\Carbon::parse($promotion->expires_at)->format('Y-m-d')) }}">
                @error('expires_at')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-footer">
            <button type="submit" class="add-btn">Update Promotion</button>
            <a href="{{ route('promotions.index') }}" class="cancel-btn">Cancel</a>
        </div>
    </form>
</div>
@endsection
