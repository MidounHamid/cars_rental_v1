@extends('admin.layouts.app')

@section('content')
<div class="table-container">
    <h2>{{ isset($car_spefication) ? 'Edit' : 'Add New' }} Car Specification</h2>

    <form
        action="{{ isset($car_spefication) ? route('car_spefications.update', $car_spefication->id) : route('car_spefications.store') }}"
        method="POST"
        enctype="multipart/form-data"
        class="car-specification-form"
    >
        @csrf
        @if(isset($car_spefication))
            @method('PUT')
        @endif

        <div class="form-row">
            <div class="form-group">
                <label for="car_id">Car</label>
                <select id="car_id" name="car_id" class="form-input">
                    <option value="">Select Car</option>
                    @foreach($cars as $car)
                        <option value="{{ $car->id }}"
                            {{ old('car_id', $car_spefication->car_id ?? '') == $car->id ? 'selected' : '' }}>
                            {{ $car->model }}
                        </option>
                    @endforeach
                </select>
                @error('car_id')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="specification_id">Specification</label>
                <select id="specification_id" name="specification_id" class="form-input">
                    <option value="">Select Specification</option>
                    @foreach($specifications as $spec)
                        <option value="{{ $spec->id }}"
                            {{ old('specification_id', $car_spefication->specification_id ?? '') == $spec->id ? 'selected' : '' }}>
                            {{ $spec->specification }}
                        </option>
                    @endforeach
                </select>
                @error('specification_id')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-footer">
            <button type="submit" class="add-btn">
                {{ isset($car_spefication) ? 'Update' : 'Create' }} Car Specification
            </button>
            <a href="{{ route('car_spefications.index') }}" class="cancel-btn">Cancel</a>
        </div>
    </form>
</div>
@endsection
