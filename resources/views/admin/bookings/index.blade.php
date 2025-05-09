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
                    <th>Times</th>
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
                                <div class="user-email small text-muted">{{ $booking->user->email }}</div>
                            </div>
                        </td>
                        <td>
                            <div class="car-info">
                                <strong>{{ $booking->car->brand->name ?? 'N/A' }} {{ $booking->car->model }}</strong>
                                <small class="d-block">{{ $booking->car->license_plate }}</small>
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
                        <td>
                            <div class="time-range">
                                <div>
                                    {{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }}
                                </div>
                                <div class="text-muted">to</div>
                                <div>
                                    {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}
                                </div>
                            </div>
                        </td>
                        <td class="text-right">
                            {{ number_format($booking->total_price, 2) }}
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
                            <span class="status-badge status-{{ strtolower($booking->status) }}">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </td>
                        <td class="actions">
                            <div class="btn-group">
                                <a href="{{ route('bookings.show', $booking->id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('bookings.edit', $booking->id) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('bookings.destroy', $booking->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Are you sure you want to delete this booking?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">No bookings found.</td>
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
