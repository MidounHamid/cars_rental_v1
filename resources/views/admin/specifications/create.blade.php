@extends('admin.layouts.app')

@section('content')
<div class="table-container">
    <h2>Add New Specification</h2>

    <form action="{{ route('specifications.store') }}" method="POST" class="specification-form">
        @csrf

        <div class="form-row">
            <div class="form-group">
                <label for="specification">Specification Name</label>
                <input type="text" id="specification" name="specification" class="form-input" value="{{ old('specification') }}" placeholder="Enter specification name">
                @error('specification')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-footer">
            <button type="submit" class="add-btn">Add Specification</button>
            <a href="{{ route('specifications.index') }}" class="cancel-btn">Cancel</a>
        </div>
    </form>
</div>
@endsection
