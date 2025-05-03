@extends('admin.layouts.app')

@section('content')
<div class="table-container">
    <div class="table-header">
        <h1>Bookings Management</h1>
        <a href="{{ route('bookings.create') }}" class="add-btn">
            <i class="fas fa-plus"></i> Add New Booking
        </a>
    </div>

    <div class="table-responsive">
        <table class="booking-table">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Car</th>
                    <th>Dates</th>
                    <th>Price</th>
                    <th>Promotion</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($bookings as $booking)
                    <tr>
                        <td>
                            <div class="user-info">
                                <div class="user-name">{{ $booking->user->name }}</div>
                            </div>
                        </td>
                        <td>
                            <div class="car-info">
                                <strong>{{ $booking->car->model }}</strong>
                                <small>{{ $booking->car->license_plate }}</small>
                            </div>
                        </td>
                        <td>
                            <div class="date-range">
                                <div>
                                        {{ $booking->start_date->format('M d, Y') }}
                                </div>
                                <div class="text-muted">to</div>
                                <div>
                                        {{ $booking->end_date->format('M d, Y') }}
                                </div>
                            </div>
                        </td>
                        <td class="text-right">
                            {{ number_format($booking->total_price, 2) }}€
                            @if($booking->promotion)
                                <div class="text-success small">
                                    <i class="fas fa-tag"></i> Saved {{ $booking->promotion->discount_percent }}%
                                </div>
                            @endif
                        </td>
                        <td>
                            @if($booking->promotion)
                                <span class="promotion-badge">
                                    {{ $booking->promotion->name }}
                                </span>
                            @else
                                <span class="text-muted">None</span>
                            @endif
                        </td>
                        <td>
                            <span class="status-badge status-{{ $booking->status }}">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </td>
                        <td class="actions">

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
                    <td colspan="6">No brands found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($bookings->hasPages())
        <div class="table-footer">
            {{ $bookings->links() }}
        </div>
    @endif
</div>
@endsection
