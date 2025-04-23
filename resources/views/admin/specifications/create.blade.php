@extends('admin.layouts.app')

@section('content')
<div class="form-container">
    <h1>Add Specification</h1>
    <form action="{{ route('specifications.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="specification">Specification</label>
            <input type="text" name="specification" id="specification" class="form-control" value="{{ old('specification') }}" required>
        </div>
        <button type="submit" class="btn btn-success">Save Specification</button>
    </form>
</div>
@endsection
