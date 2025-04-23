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
                    <td>{{ $review->rating }}</td>
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
                    <td colspan="5">No reviews found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
