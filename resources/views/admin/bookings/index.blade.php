@extends('admin.layouts.app')

@section('content')
<div class="table-container">
    <h1>bookings</h1>
    <a href="{{ route('bookings.create') }}" class="add-btn">Add booking</a>
    <table>
        <thead>
            <tr>
                <th>User</th>
                <th>Car</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Total Price</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($bookings as $booking)
                <tr>
                    <td>{{ $booking->user->name }}</td>
                    <td>{{ $booking->car->model }}</td>
                    <td>{{ $booking->start_date}}</td>
                    <td>{{ $booking->end_date }}</td>
                    <td>{{ $booking->total_price }}</td>
                    <td>
                        <span class="status-badge {{ $booking->status }}">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('bookings.edit', $booking->id) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('bookings.destroy', $booking->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this booking?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">No bookings found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

