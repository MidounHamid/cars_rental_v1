@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h1>Car Specifications</h1>
    <a href="{{ route('car_spefications.create') }}" class="add-btn">Add New Car Specification</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Car</th>
                <th>Specification</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($carSpecifications as $item)
                <tr>
                    <td>{{ $item->car->model ?? 'Unknown Car' }}</td>
                    <td>{{ $item->specification->specification ?? 'Unknown Specification' }}</td>
                    <td>
                        <a href="{{ route('car_spefications.edit', $item->id) }}" class="btn btn-primary btn-sm">Edit</a>
                        <form action="{{ route('car_spefications.destroy', $item->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this item?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">No car specifications found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
