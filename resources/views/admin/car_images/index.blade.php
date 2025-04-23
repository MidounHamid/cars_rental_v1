@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h1>Car Images</h1>
    <a href="{{ route('car_images.create') }}"  class="add-btn">Add New Image</a>

    <table>
        <thead>
            <tr>
                <th>Car ID</th>
                <th>Image</th>
                <th>Primary</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($carImages as $image)
                <tr>
                    <td>{{ $image->car_id }}</td>
                    <td><img src="{{ asset('storage/' . $image->image_path) }}" alt="Car Image" width="100"></td>
                    <td>{{ $image->is_primary ? 'Yes' : 'No' }}</td>
                    <td>{{ $image->created_at }}</td>
                    <td>
                        <a href="{{ route('car_images.edit', $image->id) }}" class="btn btn-primary btn-sm">Edit</a>
                        <form action="{{ route('car_images.destroy', $image->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure to delete this image?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">No images found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
