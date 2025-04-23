@extends('admin.layouts.app')

@section('content')

<div class="table-container">

    <h2>Edit Fuel Type</h2>

    <form action="{{ route('fuel_types.update', $fuel_type->id) }}" method="POST" class="fuel-type-form">

        @csrf

        @method('PUT')

        <div class="form-row">

            <div class="form-group">

                <label for="fuel_type">Fuel Type Name</label>

                <input type="text" id="fuel_type" name="fuel_type" class="form-input" value="{{ old('fuel_type', $fuel_type->fuel_type) }}">

                @error('fuel_type')

                    <span class="error-message">{{ $message }}</span>

                @enderror

            </div>

        </div>

        <div class="form-footer">

            <button type="submit" class="add-btn">Update Fuel Type</button>

            <a href="{{ route('fuel_types.index') }}" class="cancel-btn">Cancel</a>

        </div>

    </form>

</div>

@endsection
