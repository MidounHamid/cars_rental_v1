@extends('admin.layouts.app')

@section('content')
<div class="table-container">
    <h1>Specifications</h1>
    <a href="{{ route('specifications.create') }}" class="add-btn">Add Specification</a>
    <table>
        <thead>
            <tr>
                <th>Specification</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($specifications as $specification)
                <tr>
                    <td>{{ $specification->specification }}</td>
                    <td>
                        <a href="{{ route('specifications.edit', $specification->id) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('specifications.destroy', $specification->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this specification?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No specifications found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
