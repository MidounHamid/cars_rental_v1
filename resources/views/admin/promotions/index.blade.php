@extends('admin.layouts.app')

@section('content')
<div class="table-container">
    <h1>Promotions</h1>
    <a href="{{ route('promotions.create') }}" class="add-btn">Add Promotion</a>
    <table>
        <thead>
            <tr>
                <th>Discount Percent</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($promotions as $promotion)
                <tr>
                    <td>{{ $promotion->discount_percent }}%</td>
                    <td>{{ $promotion->starts_at }}</td>
                    <td>{{ $promotion->expires_at }}</td>
                    <td>
                        <a href="{{ route('promotions.edit', $promotion->id) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('promotions.destroy', $promotion->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this promotion?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No promotions found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
