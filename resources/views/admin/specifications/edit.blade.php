@extends('admin.layouts.app')

@section('content')
<div class="form-container">
    <h1>Edit Specification</h1>
    <form action="{{ route('specifications.update', $specification->id) }}" method="POST">
        @csrf
        @method('PUT') <!-- Spécifie que cette requête est de type PUT pour la mise à jour -->
        <div class="form-group">
            <label for="specification">Specification</label>
            <input type="text" name="specification" id="specification" class="form-control" value="{{ old('specification', $specification->specification) }}" required>
        </div>
        <button type="submit" class="btn btn-success">Update Specification</button>
    </form>
</div>
@endsection
