@extends('admin.layouts.app')

@section('content')
<div class="table-container">
    <h1>Fuel Types</h1>
    <a href="{{ route('fuel_types.create') }}" class="add-btn">Add Fuel Type</a>
    <table>
        <thead>
            <tr>
                <th>Fuel Type</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($fuelTypes as $fuelType)
                <tr>
                    <td>{{ $fuelType->fuel_type }}</td>
                    <td>
                        <a href="{{ route('fuel_types.edit', $fuelType->id) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('fuel_types.destroy', $fuelType->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this fuel type?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="2">No fuel types found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
