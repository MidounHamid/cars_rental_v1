@extends('admin.layouts.app')

@section('content')
<div class="table-container">
    <h2>Car Delivery Locations</h2>
    <a href="{{ route('car_delivery_locations.create') }}" class="add-btn">Add Car Delivery Location</a>
    <table>
        <thead>
            <tr>
                <th>Car</th>
                <th>Location</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($carDeliveries as $carDeliverie)
                <tr>
                    <td>{{ $carDeliverie->car->model }}</td> <!-- Assuming `Car` model has a `name` attribute -->
                    <td>{{ $carDeliverie->location->name }}</td> <!-- Assuming `Location` model has a `name` attribute -->
                    <td>
                        <a href="{{ route('car_delivery_locations.edit', $carDeliverie->id) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('car_delivery_locations.destroy', $carDeliverie->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this car delivery location?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">No car delivery locations found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
