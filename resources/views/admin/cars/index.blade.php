@extends('admin.layouts.app')

@section('content')
<div class="table-container">
    <h1>Cars</h1>
    <a href="{{ route('cars.create') }}" class="add-btn">Add Car</a>
    <table>
        <thead>
            <tr>
                <th>Model</th>
                <th>Car Type</th>
                <th>Fuel Type</th>
                <th>Agency</th>
                <th>Brand</th>
                <th>Insurance</th>
                <th>City</th>
                <th>Price per Day</th>
                <th>Transmission</th>
                <th>Seats</th>
                <th>Is Available</th>
                <th>Primary Image</th>
                <th>Delivery Locations</th> <!-- New column for delivery locations -->
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($cars as $car)
                <tr>
                    <td>{{ $car->model }}</td>
                    <td>{{ $car->carType ? $car->carType->name : 'N/A' }}</td>
                    <td>{{ $car->fuelType ? $car->fuelType->fuel_type : 'N/A' }}</td>
                    <td>{{ $car->agency ? $car->agency->name : 'N/A' }}</td>
                    <td>{{ $car->brand ? $car->brand->brand : 'N/A' }}</td>
                    <td>{{ $car->insurance ? $car->insurance->name : 'N/A' }}</td>
                    <td>{{ $car->city }}</td>
                    <td>{{ $car->price_per_day }}</td>
                    <td>{{ $car->transmission }}</td>
                    <td>{{ $car->seats }}</td>
                    <td>{{ $car->is_available ? 'Yes' : 'No' }}</td>

                    <!-- Display the primary image -->
                    <td>
                        @if($car->primaryImage)
                            <img src="{{ asset('storage/'.$car->primaryImage->path) }}" alt="Primary Image" style="width: 50px; height: auto;">
                        @else
                            N/A
                        @endif
                    </td>

                    <!-- Display the delivery locations -->
                    <td>
                        @forelse ($car->deliveryLocations as $location)
                            <span>{{ $location->name }}</span><br>
                        @empty
                            N/A
                        @endforelse
                    </td>

                    <td>
                        <a href="{{ route('cars.edit', $car->id) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('cars.destroy', $car->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this car?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="14">No cars found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Add pagination -->
    {{ $cars->links('vendor.pagination.custom') }}
</div>
@endsection
