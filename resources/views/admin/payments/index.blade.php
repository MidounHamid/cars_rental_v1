
@extends('admin.layouts.app')

@section('content')
<div class="table-container">
    <h1>Payments</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <a href="{{ route('payments.create') }}" class="add-btn">Add Payment</a>
    <table>
        <thead>
            <tr>
                <th>Booking ID</th>
                <th>Amount</th>
                <th>Method</th>
                <th>Status</th>
                <th>Transaction ID</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($payments as $payment)
                <tr>
                    <td>{{ $payment->booking_id }}</td>
                    <td>{{ $payment->amount }}</td>
                    <td>{{ $payment->modePayment->mode_payment ?? 'N/A' }}</td>
                    <td>
                        <span class="status-badge status-{{ $payment->status }}">
                            {{ ucfirst($payment->status) }}
                        </span>
                    </td>
                    <td>{{ $payment->transaction_id ?? 'N/A' }}</td>
                    <td>
                        <a href="{{ route('payments.edit', $payment->id) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('payments.destroy', $payment->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this payment?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No payments found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $payments->links() }}
</div>
@endsection
