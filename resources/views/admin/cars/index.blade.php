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
                    <th>Price/Day</th>
                    <th>Transmission</th>
                    <th>Seats</th>
                    <th>Available</th>
                    <th>Image</th>
                    <th>Delivery Locations</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($cars as $car)
                    <tr>
                        <td>{{ $car->model }}</td>
                        <td>{{ $car->carType?->name ?? 'N/A' }}</td>
                        <td>{{ $car->fuelType?->fuel_type ?? 'N/A' }}</td>
                        <td>{{ $car->agency?->name ?? 'N/A' }}</td>
                        <td>{{ $car->brand?->brand ?? 'N/A' }}</td>
                        <td>{{ $car->insurance?->name ?? 'N/A' }}</td>
                        <td>{{ $car->city }}</td>
                        <td>{{ number_format($car->price_per_day, 2) }}</td>
                        <td>{{ $car->transmission }}</td>
                        <td>{{ $car->seats }}</td>
                        <td>{{ $car->is_available ? 'Yes' : 'No' }}</td>

                        <td>
                            @if ($car->primaryImage)
                                <img src="{{ asset('storage/' . $car->primaryImage->image_path) }}"
                                     alt="Car Image" style="width: 60px; height: auto; border-radius: 4px;">
                            @else
                                N/A
                            @endif
                        </td>

                        <td>
                            @forelse ($car->deliveryLocations as $location)
                                <span class="badge">
                                    {{ $location->name }} - {{ ucfirst(str_replace('_', ' ', $location->type)) }}
                                </span><br>
                            @empty
                                N/A
                            @endforelse
                        </td>

                        <td>
                            <a href="{{ route('cars.edit', $car->id) }}" class="btn btn-primary">Edit</a>
                            <form action="{{ route('cars.destroy', $car->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                        onclick="return confirm('Are you sure you want to delete this car?')">
                                    Delete
                                </button>
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

        <!-- Pagination -->
        <div class="pagination-wrapper">
            {{ $cars->links('vendor.pagination.custom') }}
        </div>
    </div>
@endsection
