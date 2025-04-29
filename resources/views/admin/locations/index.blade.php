@extends('admin.layouts.app')

@section('content')
<div class="table-container">
    <h1>Locations</h1>
    <a href="{{ route('locations.create') }}" class="add-btn">Add Location</a>
    <table>
        <thead>
            <tr>
                <th>Location Name</th>
                <th>Type</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($locations as $location)
                <tr>
                    <td>{{ $location->name }}</td>
                    <td>{{ ucfirst($location->type) }}</td>
                    <td>
                        <a href="{{ route('locations.edit', $location->id) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('locations.destroy', $location->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this location?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">No locations found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
