@extends('admin.layouts.app')

@section('content')
<div class="table-container">
    <h1>Payment Modes</h1>
    <a href="{{ route('mode_payments.create') }}" class="add-btn">Add Payment Mode</a>
    <table>
        <thead>
            <tr>
                <th>Payment Mode</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($modePayments as $modePayment)
                <tr>
                    <td>{{ $modePayment->mode_payment }}</td>
                    <td>
                        <a href="{{ route('mode_payments.edit', $modePayment->id) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('mode_payments.destroy', $modePayment->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this payment mode?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No payment modes found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
