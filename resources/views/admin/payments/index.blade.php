@extends('admin.layouts.app')

@section('content')
<div class="table-container">
    <h1>Payments</h1>
    <a href="{{ route('payments.create') }}" class="add-btn">Add Payment</a>
    <table>
        <thead>
            <tr>
                <th>Booking ID</th>
                <th>Amount</th>
                <th>Method</th>
                <th>Transaction ID</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($payments as $payment)
                <tr>
                    <td>{{ $payment->booking_id }}</td>
                    <td>{{ $payment->amount }}</td>
                    <td>{{ $payment->method }}</td>
                    <td>{{ $payment->transaction_id }}</td>
                    <td>{{ $payment->status }}</td>
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
</div>
@endsection
