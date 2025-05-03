@extends('admin.layouts.app')

@section('content')
<div class="table-container">
    <h1>Reviews</h1>
    <a href="{{ route('reviews.create') }}" class="add-btn">Add Review</a>
    <table>
        <thead>
            <tr>
                <th>User</th>
                <th>Car</th>
                <th>Rating</th>
                <th>Comment</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($reviews as $review)
                <tr>
                    <td>{{ $review->user->name }}</td>
                    <td>{{ $review->car->model }}</td>
                    <td>
                        <!-- Star Rating -->
                        @for ($i = 1; $i <= 5; $i++)
                            <span class="fas fa-star {{ $i <= $review->rating ? 'filled' : '' }}"></span>
                        @endfor
                    </td>
                    <td>{{ $review->comment }}</td>
                    <td>
                        <a href="{{ route('reviews.edit', $review->id) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('reviews.destroy', $review->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this review?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No reviews found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

@push('styles')
<!-- Font Awesome 6 for star icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<style>
    .fa-star {
        color: #d3d3d3; /* Light grey for unfilled stars */
    }
    .fa-star.filled {
        color: #ffcc00; /* Gold color for filled stars */
    }
</style>
@endpush
