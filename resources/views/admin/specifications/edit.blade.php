@extends('admin.layouts.app')

@section('content')
<div class="table-container">
    <h2>Edit Specification</h2>
    <form action="{{ route('specifications.update', $specification->id) }}" method="POST" class="specification-form">
        @csrf
        @method('PUT')

        <div class="form-row">
            <div class="form-group">
                <label for="specification">Specification Name</label>
                <input type="text" id="specification" name="specification" class="form-input" value="{{ old('specification', $specification->specification) }}" required>
                @error('specification')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-footer">
            <button type="submit" class="add-btn">Update Specification</button>
            <a href="{{ route('specifications.index') }}" class="cancel-btn">Cancel</a>
        </div>
    </form>
</div>
@endsection
