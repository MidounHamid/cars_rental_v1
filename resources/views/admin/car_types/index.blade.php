@extends('admin.layouts.app')

@section('content')
<div class="table-container">
    <h1>Car Types</h1>
    <a href="{{ route('car_types.create') }}" class="add-btn">Add Car Type</a>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($carTypes as $carType)
                <tr>
                    <td>{{ $carType->name }}</td>
                    <td>{{ $carType->description }}</td>
                    <td>
                        <a href="{{ route('car_types.edit', $carType->id) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('car_types.destroy', $carType->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this car type?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">No car types found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
